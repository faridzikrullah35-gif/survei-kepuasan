<?php

namespace App\Http\Controllers;

use App\Models\Instrumen;
use App\Models\NilaiInstrumenMahasiswa;
use App\Models\TahunAkademik;
use App\Models\Nilai;
use App\Models\Pertanyaan;
use App\Models\JawabanKritik;
use App\Models\InstrumenNonAktif;
use App\Models\BiodataResponden;
use App\Models\Chart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class InstrumenController extends Controller
{

    public function index(Request $request)
    {
        $role = auth()->user()->role;
        
        $pertanyaan = Pertanyaan::all();

        $query = Instrumen::with([
            'tahunAkademik',
            'survei',
            'nilai',
            'pertanyaan.survei',
            'nilaiInstrumenMahasiswa' => fn($q) => $q->where('user_id', auth()->id())
        ]);

        if ($role !== 'admin') {
            $query->where('role', $role);
        }

        if ($request->filled('tahun_akademik_id')) {
            $query->where('tahun_akademik_id', $request->tahun_akademik_id);
        }

        if ($request->filled('standar_filter')) {
            $query->whereHas('survei', fn($q) => $q->where('standar', $request->standar_filter));
        }

        if ($request->filled('pertanyaan_id')) {
            $query->where('pertanyaan_id', $request->pertanyaan_id);
        }

        if ($request->filled('instrumen_id')) {
            $query->whereHas('pertanyaan', fn($q) => $q->where('instrumen_id', $request->instrumen_id));
        }

        $instrumens = $query
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $standarList = \App\Models\Survei::select('standar')
            ->distinct()
            ->pluck('standar');
        
        // ambil data untuk blade
        $dataBlade = $this->prepareInstrumenData($instrumens);

        // Tahun Akademik dropdown
        $tahunAkademik = TahunAkademik::orderBy('tahun', 'asc')->get();

        return view('instrumen.index', array_merge(
            [
                'instrumens' => $instrumens, 
                'tahunAkademik' => $tahunAkademik, 
                'pertanyaan' => $pertanyaan,
                'standarList' => $standarList
            ],
            $dataBlade,
            ['fromDashboard' => false]
        ));
    }

    public function byStandar($standar)
    {
        $role = auth()->user()->role;

        // Ambil instrumen beserta jawaban user
        $instrumens = Instrumen::with([
            'tahunAkademik',
            'pertanyaan',
            'nilaiInstrumenMahasiswa' => fn($q) => $q->where('user_id', auth()->id())
        ])->whereHas('pertanyaan', fn($q) =>
            $q->whereHas('survei', fn($s) => $s->where('standar', $standar))
        )
        ->when($role !== 'admin', fn($q) => $q->where('role', $role))
        ->get();

        // Mapping jawaban per instrumen
        $jawabanUserMap = $instrumens->mapWithKeys(fn($instrumen) => [
            $instrumen->id => $instrumen->nilaiInstrumenMahasiswa->first()
        ]);

        // Cek sudah menjawab
        $sudahMenjawab = $jawabanUserMap->filter()->count() > 0;

        // Ambil kritik & saran terakhir user
        $kritikSaran = $jawabanUserMap->filter(fn($jawaban) => $jawaban && $jawaban->kritik_saran)
            ->first()?->kritik_saran ?? '';

        // Biodata & standar
        $biodata = BiodataResponden::where('user_id', auth()->id())->first();
        $standars = \App\Models\Standar::pluck('nama', 'id');

        return view('instrumen.index', compact(
            'instrumens', 'jawabanUserMap', 'sudahMenjawab', 'kritikSaran', 'standars', 'biodata'
        ))->with('fromDashboard', true);
    }

    /**
     * Helper untuk siapkan data blade
     */
    private function prepareInstrumenData($instrumens)
    {
        $jawabanUserMap = [];
        $kritikSaran = '';

        foreach ($instrumens as $instrumen) {
            $jawaban = $instrumen->nilaiInstrumenMahasiswa->first();
            if ($jawaban) {
                $jawabanUserMap[$instrumen->id] = $jawaban;
                if (empty($kritikSaran) && !empty($jawaban->kritik_saran)) {
                    $kritikSaran = $jawaban->kritik_saran;
                }
            }
        }

        $sudahMenjawab = count($jawabanUserMap) > 0;

        $standars = \App\Models\Standar::pluck('nama', 'id');
        $biodata = BiodataResponden::where('user_id', auth()->id())->first();

        return compact('jawabanUserMap', 'sudahMenjawab', 'kritikSaran', 'standars', 'biodata');
    }


    public function store(Request $request)
    {

        $request->validate([
            'tahun_akademik' => 'required|array|min:1',
            'role' => 'required|in:admin,mahasiswa,dosen,tenaga_kependidikan,user',
        ]);

        $tahunAkademikId = $request->input('tahun_akademik')[0];

        $tahunAkademik = TahunAkademik::find($tahunAkademikId);

        if (!$tahunAkademik) {
            return redirect()->route('survei.index')
                ->with('error', 'Tahun Akademik tidak ditemukan!');
        }

        /**
         * Jika klik tombol pilih semua
         */
        if ($request->select_all == 1) {

            $pertanyaanIds = Pertanyaan::pluck('id')->toArray();

        } else {

            $request->validate([
                'pertanyaan_ids' => 'required|array|min:1',
                'pertanyaan_ids.*' => 'exists:pertanyaan,id',
            ]);

            $pertanyaanIds = $request->pertanyaan_ids;

        }

        /**
         * Tahun akademik NON AKTIF
         */
        if ($tahunAkademik->status == 'Non-Aktif') {

            foreach ($pertanyaanIds as $pertanyaanId) {

                $nilaiId = Nilai::where('pertanyaan_id', $pertanyaanId)->value('id') ?? 1;

                InstrumenNonAktif::create([
                    'tahun_akademik_id' => $tahunAkademikId,
                    'pertanyaan_id' => $pertanyaanId,
                    'nilai_id' => $nilaiId,
                    'status' => 'Non-Aktif',
                ]);
            }

            return redirect()->route('survei.index')
                ->with('success', 'Data disimpan ke Instrumen Non-Aktif karena Tahun Akademik Non-Aktif!');
        }

        /**
         * Tahun akademik AKTIF
         */
        foreach ($pertanyaanIds as $pertanyaanId) {

            $nilaiId = Nilai::where('pertanyaan_id', $pertanyaanId)->value('id') ?? 1;

            Instrumen::create([
                'tahun_akademik_id' => $tahunAkademikId,
                'pertanyaan_id' => $pertanyaanId,
                'nilai_id' => $nilaiId,
                'role' => $request->role,
            ]);
        }

        return redirect()->route('survei.index')
            ->with('success', 'Data Survei Berhasil Ditambahkan ke Instrumen!');
    }

    public function show(Request $request)
    {

        $shows = InstrumenNonAktif::all();

        return view('instrumen.nonaktif', compact('shows'));
    }


    public function destroy($id)
    {

        $item = Instrumen::findOrFail($id);

        $item->delete();

        return redirect()->back()->with('success', 'Instrumen berhasil dihapus.');
    }


    public function destroyAll()
    {
    Schema::disableForeignKeyConstraints();

    Chart::truncate();
    Instrumen::truncate();

    Schema::enableForeignKeyConstraints();

    return redirect()->back()->with('success', 'Semua instrumen berhasil dihapus.');
    }

    public function simpanJawabanKritik(Request $request)
    {
        $request->validate([
            'kritik_id' => 'required|exists:kritik_saran,id',
            'jawaban' => 'required|string',
        ]);

        $kritik = \App\Models\KritikSaran::find($request->kritik_id);
        $user = $request->user();

        JawabanKritik::updateOrCreate(
            [
                'kritik_saran_id' => $kritik->id,
                'user_id' => $user->id,
            ],
            [
                'standar_id' => $kritik->standar_id,
                'role' => $user->role,
                'subjek' => $kritik->subjek ?? 'Kritik',
                'isi' => $request->jawaban,
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Jawaban berhasil disimpan',
        ]);
    }
    
}
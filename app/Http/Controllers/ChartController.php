<?php

namespace App\Http\Controllers;

use App\Models\NilaiInstrumenMahasiswa;
use App\Models\Instrumen;
use App\Models\TahunAkademik;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\HasilSurveiExport;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function index(Request $request)
    {
        $tahunAkademik = TahunAkademik::where('status', 'Aktif')->get();

        $tahunAkademikId = $request->input('tahun_akademik_id');
        $standarDipilih  = $request->input('instrumen_id');
        $roleDipilih     = $request->input('role');

        /*
        |--------------------------------------------------------------------------
        | Dropdown Standar (ambil dari instrumen → pertanyaan)
        |--------------------------------------------------------------------------
        */

        $queryInstrumenDropdown = Instrumen::join('pertanyaan as p', 'p.id', '=', 'instrumen.pertanyaan_id');

        if ($tahunAkademikId) {
            $queryInstrumenDropdown->where('instrumen.tahun_akademik_id', $tahunAkademikId);
        }

        // ambil semua standar unik
        $instrumenUntukDropdown = $queryInstrumenDropdown
            ->select(DB::raw('MIN(instrumen.id) as id'), 'p.standar')
            ->whereNotNull('p.standar')
            ->groupBy('p.standar')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Ambil semua instrumen dari standar yang sama
        |--------------------------------------------------------------------------
        */

        $instrumenIds = collect();

        if ($standarDipilih) {
            $standar = DB::table('instrumen')
                ->join('pertanyaan as p', 'p.id', '=', 'instrumen.pertanyaan_id')
                ->where('instrumen.id', $standarDipilih)
                ->value('p.standar');

            $instrumenIds = DB::table('instrumen')
                ->join('pertanyaan as p', 'p.id', '=', 'instrumen.pertanyaan_id')
                ->where('p.standar', $standar)
                ->pluck('instrumen.id');
        } else {
            // kalau standar ga dipilih, ambil semua instrumen
            $instrumenIds = DB::table('instrumen')->pluck('id');
        }

        /*
        |--------------------------------------------------------------------------
        | Base Query
        |--------------------------------------------------------------------------
        */

        $baseQuery = DB::table('nilai_instrumen_mahasiswa as n')
            ->join('users as u', 'u.id', '=', 'n.user_id')
            ->join('instrumen as i', 'i.id', '=', 'n.instrumen_id')
            ->join('pertanyaan as p', 'p.id', '=', 'i.pertanyaan_id')
            ->join('tahun_akademik as t', 't.id', '=', 'i.tahun_akademik_id')
            ->where('n.status', 'terjawab');

        if ($tahunAkademikId) {
            $baseQuery->where('i.tahun_akademik_id', $tahunAkademikId);
        }

        if ($instrumenIds->isNotEmpty()) {
            $baseQuery->whereIn('n.instrumen_id', $instrumenIds);
        }

        // role sudah fleksibel
        if ($roleDipilih) {
            $baseQuery->where('u.role', $roleDipilih);
        }

        /*
        |--------------------------------------------------------------------------
        | Distribusi Nilai
        |--------------------------------------------------------------------------
        */

        $nilaiCounts = (clone $baseQuery)
            ->select(
                DB::raw('SUM(n.nilai = 1) as nilai_1'),
                DB::raw('SUM(n.nilai = 2) as nilai_2'),
                DB::raw('SUM(n.nilai = 3) as nilai_3'),
                DB::raw('SUM(n.nilai = 4) as nilai_4'),
                DB::raw('COUNT(*) as total')
            )
            ->first();

        /*
        |--------------------------------------------------------------------------
        | Summary Per Role
        |--------------------------------------------------------------------------
        */

        $summaryPerRole = (clone $baseQuery)
            ->select(
                'u.role',
                DB::raw('SUM(n.nilai = 1) as nilai_1'),
                DB::raw('SUM(n.nilai = 2) as nilai_2'),
                DB::raw('SUM(n.nilai = 3) as nilai_3'),
                DB::raw('SUM(n.nilai = 4) as nilai_4'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('u.role')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Kritik & Saran (1 per pertanyaan)
        |--------------------------------------------------------------------------
        */

        $kritikSaran = DB::table('nilai_instrumen_mahasiswa as n')
            ->join('instrumen as i', 'i.id', '=', 'n.instrumen_id')
            ->join('pertanyaan as p', 'p.id', '=', 'i.pertanyaan_id')
            ->where('n.status', 'terjawab')
            ->select(
                'p.pertanyaan',
                DB::raw('MAX(n.kritik_saran) as kritik_saran')
            )
            ->groupBy('p.pertanyaan')
            ->pluck('kritik_saran', 'p.pertanyaan');

        /*
        |--------------------------------------------------------------------------
        | Detail Table
        |--------------------------------------------------------------------------
        */

        $data = (clone $baseQuery)
            ->select(
                'u.name',
                'u.role',
                't.tahun as tahun_akademik',
                'p.standar',
                'p.pertanyaan',
                'n.nilai'
            )
            ->orderBy('p.id')
            ->paginate(20) // <-- paginate 50 baris per halaman
            ->through(function ($item) use ($kritikSaran) {
                $item->kritik_saran = $kritikSaran[$item->pertanyaan] ?? '-';
                return $item;
            });

        /*
        |--------------------------------------------------------------------------
        | Total User
        |--------------------------------------------------------------------------
        */

        $totalMahasiswa = DB::table('users')->where('role', 'mahasiswa')->count();
        $totalDosen = DB::table('users')->where('role', 'dosen')->count();
        $totalTenagaKependidikan = DB::table('users')->where('role', 'tenaga_kependidikan')->count();

        return view('chart.index', compact(
            'tahunAkademik',
            'instrumenUntukDropdown',
            'nilaiCounts',
            'summaryPerRole',
            'data',
            'totalMahasiswa',
            'totalDosen',
            'totalTenagaKependidikan'
        ));
    }

    public function getInstrumen(Request $request)
    {
        $tahunAkademikId = $request->get('tahun_akademik_id');

        $query = DB::table('instrumen')
            ->join('pertanyaan as p', 'p.id', '=', 'instrumen.pertanyaan_id')
            ->whereNotNull('p.standar');

        // hanya filter jika ada tahun akademik
        if ($tahunAkademikId) {
            $query->where('instrumen.tahun_akademik_id', $tahunAkademikId);
        }

        $instrumen = $query
            ->select(DB::raw('MIN(instrumen.id) as id'), 'p.standar')
            ->groupBy('p.standar')
            ->orderBy('p.standar')
            ->get();

        return response()->json($instrumen);
    }

    public function export(Request $request)
    {
        return Excel::download(
            new HasilSurveiExport($request->instrumen_id),
            'hasil-survei.xlsx'
        );
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\InstrumenTeks;
use App\Models\SurveiTeks;
use App\Models\NilaiInstrumenTeks;
use App\Models\PertanyaanTeks;
use App\Models\TahunAkademikTeks;
use App\Models\InstrumenTeksNonAktif;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InstrumenTeksController extends Controller
{
    public function index(Request $request)
    {
        $items = InstrumenTeksNonAktif::all();

        $role = auth()->user()->role;
        $userId = auth()->id();

        $query = InstrumenTeks::with(['pertanyaanTeks', 'nilaiInstrumenTeks', 'tahunAkademikTeks']);

        // Filter berdasarkan role (kecuali admin melihat semua)
        if ($role !== 'admin') {
            $query->where('role', $role);
        }

        if ($request->has('tahun_akademik_teks_id') && $request->tahun_akademik_teks_id) {
            $query->where('tahun_akademik_teks_id', $request->tahun_akademik_teks_id);
        }

        if ($request->has('pertanyaan_teks_id') && $request->pertanyaan_teks_id) {
            $query->where('pertanyaan_teks_id', $request->pertanyaan_teks_id);
        }

        $pertanyaanTeksQuery = PertanyaanTeks::query();

        if ($role === 'admin') {
            $pertanyaanTeksQuery->orderBy('standar', 'asc');
        } else {
            $pertanyaanTeksQuery->whereHas('instrumenTeks', function ($q) use ($role) {
                $q->where('role', $role);
            });
        }

        $pertanyaanTeks = $pertanyaanTeksQuery->get();
        $instrumenTeks = $query->get();
        $tahunAkademikTeks = TahunAkademikTeks::orderBy('tahun', 'asc')->get();
        $nilaiInstrumenTeks = NilaiInstrumenTeks::where('role', $role)->get();

        return view('instrumen_teks.index', compact(
            'instrumenTeks',
            'pertanyaanTeks',
            'nilaiInstrumenTeks',
            'tahunAkademikTeks',
            'items'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun_akademik_teks' => 'required|array|min:1',
            'tahun_akademik_teks.*' => 'exists:survei_tahun_teks,id',
            'role' => 'required|string|exists:users,role', // Tidak hardcoded
            'pertanyaan_teks_ids' => 'required|array|min:1',
            'pertanyaan_teks_ids.*' => 'exists:survei_teks,id',
        ]);

        $role = $request->input('role');

        foreach ($request->tahun_akademik_teks as $tahunAkademikTeksId) {
            $tahunAkademikTeks = TahunAkademikTeks::find($tahunAkademikTeksId);

            if ($tahunAkademikTeks && $tahunAkademikTeks->status === 'Non-Aktif') {
                foreach ($request->pertanyaan_teks_ids as $pertanyaanTeksId) {
                    InstrumenTeksNonAktif::create([
                        'tahun_akademik_teks_id' => $tahunAkademikTeksId,
                        'pertanyaan_teks_id' => $pertanyaanTeksId,
                        'status' => 'Non-Aktif',
                    ]);
                }

                return redirect()->route('survei-teks.index')
                    ->with('success', 'Data disimpan ke Instrumen Teks Non-Aktif karena Tahun Akademik Teks Non-Aktif!');
            }

            foreach ($request->pertanyaan_teks_ids as $pertanyaanTeksId) {
                InstrumenTeks::create([
                    'tahun_akademik_teks_id' => $tahunAkademikTeksId,
                    'pertanyaan_teks_id' => $pertanyaanTeksId,
                    'status' => 'belum terjawab',
                    'role' => $role,
                ]);
            }
        }

        return redirect()->route('survei-teks.index')
            ->with('success', 'Instrumen Teks berhasil ditambahkan!');
    }

    public function showInstrumenTeksNonaktif()
    {
        $nonaktif = InstrumenTeksNonAktif::with(['tahunAkademikTeks', 'pertanyaanTeks'])->get();
        return view('instrumen_teks.nonaktif', compact('nonaktif'));
    }

    public function destroyInstrumenTeksNonAktif($id)
    {
        $item = InstrumenTeksNonAktif::findOrFail($id);
        $item->delete();

        return redirect()->route('index.nonaktif')
            ->with('success', 'Instrumen Non-Aktif berhasil dihapus!');
    }

    public function byStandar($standar)
    {
        $items = InstrumenTeksNonAktif::all();

        $role = auth()->user()->role;
        $userId = auth()->id();

        $query = InstrumenTeks::with(['pertanyaanTeks', 'nilaiInstrumenTeks', 'tahunAkademikTeks'])
            ->whereHas('pertanyaanTeks', function ($q) use ($standar) {
                $q->where('standar', $standar);
            });

        // filter role (sama kayak index)
        if ($role !== 'admin') {
            $query->where('role', $role);
        }

        $instrumenTeks = $query->get();

        // === INI WAJIB, karena dipakai di blade index ===
        $pertanyaanTeks = PertanyaanTeks::where('standar', $standar)->get();
        $tahunAkademikTeks = TahunAkademikTeks::orderBy('tahun', 'asc')->get();
        $nilaiInstrumenTeks = NilaiInstrumenTeks::where('role', $role)->get();

        return view('instrumen_teks.index', compact(
            'instrumenTeks',
            'pertanyaanTeks',
            'nilaiInstrumenTeks',
            'tahunAkademikTeks',
            'items'
        ));
    }

}

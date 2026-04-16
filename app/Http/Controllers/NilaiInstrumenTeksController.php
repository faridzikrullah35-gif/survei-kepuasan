<?php

namespace App\Http\Controllers;

use App\Models\NilaiInstrumenTeks;
use App\Models\InstrumenTeks;
use App\Models\Jawaban;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NilaiInstrumenTeksController extends Controller
{
    /**
     * Menampilkan data Nilai Instrumen Teks.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $role = auth()->user()->role;

        $nilaiInstrumenTeks = NilaiInstrumenTeks::where('role', $role)
            ->when($request->instrumen_teks_id, function ($query) use ($request) {
                $query->where('instrumen_teks_id', $request->instrumen_teks_id);
            })
            ->get();

        return view('instrumen_teks.index', compact('nilaiInstrumenTeks'));
    }
    /**
     * Menyimpan data Nilai Instrumen Teks ke database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'instrumen_teks_id' => 'required|exists:instrumen_teks,id',
            'jawaban' => 'required|string',
        ]);

        // Cek apakah user sudah menjawab
        $existing = NilaiInstrumenTeks::where('instrumen_teks_id', $request->instrumen_teks_id)
            ->where('user_id', Auth::id())
            ->exists();

        if ($existing) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah memberikan jawaban untuk survei ini.'
                ], 400);
            }

            return redirect()->back()->with('error', 'Anda sudah memberikan jawaban untuk survei ini.');
        }

        // Simpan ke nilai_instrumen_teks
        $nilaiInstrumenTeks = NilaiInstrumenTeks::create([
            'user_id' => Auth::id(),
            'role' => Auth::user()->role,
            'instrumen_teks_id' => $request->instrumen_teks_id,
            'jawaban' => $request->jawaban,
            'status' => 'terjawab',
        ]);

        $instrumenTeks = InstrumenTeks::find($request->instrumen_teks_id);

        if (!$instrumenTeks) {
            return response()->json([
                'success' => false,
                'message' => 'Instrumen Teks tidak ditemukan.'
            ], 404);
        }

        // Simpan ke tabel jawaban
        $jawaban = Jawaban::create([
            'instrumen_teks_id' => $request->instrumen_teks_id,
            'nilai_instrumen_teks_id' => $nilaiInstrumenTeks->id,
            'tahun_akademik_teks_id' => $instrumenTeks->tahun_akademik_teks_id,
            'pertanyaan_teks_id' => $instrumenTeks->pertanyaan_teks_id,
            'tahun' => $instrumenTeks->tahun ?? 'Tidak ada',
            'standar' => $instrumenTeks->standar ?? 'Tidak ada',
            'pertanyaan' => $instrumenTeks->pertanyaan ?? 'Tidak ada',
            'jawaban' => $request->jawaban,
        ]);

        // ✅ RESPONSE AJAX YANG CLEAN & LENGKAP
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'jawaban' => $jawaban->jawaban,
                'tanggal' => $jawaban->created_at->format('d M Y H:i'),
                'created_at' => $jawaban->created_at,
                'message' => 'Jawaban berhasil disimpan!'
            ]);
        }

        return redirect()->back()->with('success', 'Jawaban berhasil disimpan!');
    }
               
}
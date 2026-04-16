<?php

namespace App\Http\Controllers;

use App\Models\Pertanyaan;
use App\Models\Nilai;
use App\Models\SurveiNilai;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    // Method untuk menampilkan data pertanyaan beserta nilai-nya
    public function index()
    {
        // Mengambil semua pertanyaan beserta nilai terkait
        $pertanyaans = Pertanyaan::with('nilai')->paginate(10);
        return view('pertanyaan.index', compact('pertanyaans'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'pertanyaan_id' => 'required|integer|exists:pertanyaan,id',
            'nilai' => 'required|integer|between:1,4', 
            'keterangan' => 'required|string|max:255',
        ]);

        // Simpan data ke database
        try {
            $nilai = new Nilai();
            $nilai->pertanyaan_id = $request->pertanyaan_id;
            $nilai->keterangan = $request->keterangan;
            $nilai->nilai = $request->input('nilai', 0);
            $nilai->save();

            return response()->json([
                'success' => true,
                'id' => $nilai->id,
                'nilai' => $nilai->nilai,
                'keterangan' => $nilai->keterangan,
            ]);

            } catch (\Exception $e) {
                return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
            }
    }


    public function list($pertanyaanId)
    {
        $pertanyaan = Pertanyaan::with('nilai')->find($pertanyaanId);
        return view('partials.nilai_list', compact('pertanyaan'));
    }

    public function show($id)
    {
        $nilai = Nilai::find($id); // Ambil data nilai berdasarkan ID
        return view('nilai.show', compact('nilai')); // Kirim data ke view
    }

    public function destroy($id)
    {
        // Cari nilai berdasarkan ID
        $nilai = Nilai::findOrFail($id);

        // Hapus nilai
        $nilai->delete();

        // Kembalikan respons JSON
        return response()->json([
            'success' => true,
            'message' => 'Nilai berhasil dihapus!'
        ]);
    }

}

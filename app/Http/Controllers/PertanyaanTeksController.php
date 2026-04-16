<?php

namespace App\Http\Controllers;

use App\Models\PertanyaanTeks;
use App\Models\SurveiTeks;
use Illuminate\Http\Request;

class PertanyaanTeksController extends Controller
{
    public function index()
    {
        $pertanyaans = PertanyaanTeks::with('surveiTeks')->paginate(10);
        
        return view('pertanyaan-teks.index', compact('pertanyaans')); 
    }

    // Menampilkan form create
    public function create()
    {
        
        return view('pertanyaan-teks.create'); 
    }

    // Menyimpan data baru
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'standar' => 'required|string|max:255',
            'pertanyaan' => 'required|string|max:255',
        ]);
    
        // Menyimpan data PertanyaanTeks
        $pertanyaanTeks = PertanyaanTeks::create([
            'standar' => $request->standar,
            'pertanyaan' => $request->pertanyaan,
        ]);
    
        // Menyimpan data SurveiTeks dengan menggunakan ID dari PertanyaanTeks
        SurveiTeks::create([
            'standar' => $request->standar,
            'pertanyaan' => $request->pertanyaan,
            'pertanyaan_teks_id' => $pertanyaanTeks->id,  // Menggunakan ID dari PertanyaanTeks
        ]);
    
        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('pertanyaan-teks.index')->with('success', 'Pertanyaan berhasil disimpan.');
    }
    
    // Menampilkan form edit
    public function edit($id)
    {
        $pertanyaan = PertanyaanTeks::with('surveiTeks')->findOrFail($id);
        return view('pertanyaan-teks.edit', compact('pertanyaan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'standar' => 'required|string|max:255',
            'pertanyaan' => 'required|string|max:500',
            'survei.*.standar' => 'nullable|string|max:255',
        ]);
    
        $pertanyaan = PertanyaanTeks::findOrFail($id);
    
        // Update data di tabel pertanyaan_teks
        $pertanyaan->update([
            'standar' => $request->standar,
            'pertanyaan' => $request->pertanyaan,
        ]);
    
        if ($request->has('survei')) {
            foreach ($request->survei as $surveiId => $surveiData) {
                $survei = SurveiTeks::find($surveiId);
                if ($survei) {
                    $survei->update([
                        'standar' => $surveiData['standar'] ?? $survei->standar,
                        'pertanyaan' => $surveiData['pertanyaan'] ?? $survei->pertanyaan,
                    ]);
                }
            }
        }        
    
        return redirect()->route('pertanyaan-teks.index')->with('success', 'Data pertanyaan dan survei berhasil diperbarui.');
    }
                
    public function show($id)
    {
        // Mendapatkan data pertanyaan berdasarkan ID
        $pertanyaan = Pertanyaan::with('nilai')->findOrFail($id);
        
        return view('pertanyaan-teks.index', compact('pertanyaan')); 
    }

    // Menghapus data
    public function destroy(PertanyaanTeks $pertanyaan)
    {
        $pertanyaan->surveiTeks()->delete();

        $pertanyaan->delete();

        return redirect()->route('pertanyaan-teks.index')->with('success', 'Pertanyaan berhasil dihapus!');
    }
}

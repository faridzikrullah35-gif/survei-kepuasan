<?php

namespace App\Http\Controllers;

use App\Models\Pertanyaan;
use App\Models\Nilai;
use App\Models\Survei;
use App\Models\TahunAkademik;
use App\Models\Standar;
use App\Models\NilaiDB;

use Illuminate\Http\Request;

class PertanyaanController extends Controller
{
    /**
     * Display a listing of pertanyaan.
     */
    public function index()
    {
        $pertanyaans = Pertanyaan::with('nilai', 'survei')
            ->latest()
            ->paginate(20);

        return view('pertanyaan.index', compact('pertanyaans'));
    }

    /**
     * Show a specific pertanyaan.
     */
    public function show($id)
    {
        $pertanyaan = Pertanyaan::findOrFail($id);
        return view('pertanyaan.show', compact('pertanyaan'));
    }

    /**
     * Get all pertanyaan as JSON.
     */
    public function getData()
    {
        $pertanyaans = Pertanyaan::all();
        return response()->json($pertanyaans);
    }

    /**
     * Show the form for creating a new pertanyaan.
     */
    public function create()
    {
        $standar = Standar::all();
        return view('pertanyaan.create', compact('standar'));
    }

    /**
     * Store a new pertanyaan.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'standar' => 'required|string|max:255',
            'new_standar' => 'nullable|string|max:255|required_if:standar,new', // Validasi standar baru jika dipilih
            'pertanyaan' => 'required|string|max:1000',
        ]);
    
        // Variabel untuk menyimpan data standar
        $standar = null;
    
        // Cek apakah standar baru dipilih
        if ($request->standar === 'new' && $request->new_standar) {
            // Simpan standar baru ke tabel `standar`
            $standar = Standar::create([
                'kode' => strtoupper(str_replace(' ', '', $request->new_standar)), // Membuat kode otomatis
                'nama' => $request->new_standar,
            ]);
        } else {
            // Gunakan standar yang dipilih berdasarkan kode
            $standar = Standar::where('kode', $request->standar)->first();
    
            if (!$standar) {
                return redirect()->back()->withErrors(['standar' => 'Standar tidak valid.']);
            }
        }
    
        // Pastikan $standar memiliki nilai
        if (!$standar) {
            return redirect()->back()->withErrors(['error' => 'Standar tidak ditemukan atau tidak valid.']);
        }
    
        // Buat pertanyaan baru
        $pertanyaan = Pertanyaan::create([
            'standar_id' => $standar->id,
            'standar' => $standar->nama,
            'pertanyaan' => $request->pertanyaan,
            
        ]);

        // Buat survei baru terkait pertanyaan
        Survei::create([
            'standar' => $standar->nama,
            'pertanyaan' => $request->pertanyaan,
            'pertanyaan_id' => $pertanyaan->id,
            'standar_id' => $standar->id,
            
        ]);

        return redirect()->route('pertanyaan.index')->with('success', 'Pertanyaan berhasil disimpan.');
    }

    /**
     * Show the form for editing a specific pertanyaan.
     */
    public function edit(Pertanyaan $pertanyaan)
    {
        $nilais = $pertanyaan->nilai;
        return view('pertanyaan.edit', compact('pertanyaan', 'nilais'));
    }

    /**
     * Update a specific pertanyaan.
     */
    public function update(Request $request, Pertanyaan $pertanyaan)
    {
        // Validasi input
        $request->validate([
            'standar' => 'required|string|max:255',
            'pertanyaan' => 'required|string',
            'survei.*.data' => 'nullable|string',
        ]);

        // Update data pertanyaan
        $pertanyaan->update([
            'standar' => $request->standar,
            'pertanyaan' => $request->pertanyaan,
        ]);

    // Update setiap data survei yang terkait
    if ($request->has('survei')) {
        foreach ($request->survei as $surveiData) {
            $survei = $pertanyaan->survei()->find($surveiData['id']);
            if ($survei) {
                $survei->update([
                    'standar' => $request->standar,
                    'pertanyaan' => $request->pertanyaan,
                ]);
            }
        }
    }

        return redirect()->route('pertanyaan.index')->with('success', 'Pertanyaan dan data survei berhasil diupdate.');
    }

    /**
     * Delete a specific pertanyaan.
     */
    public function destroy(Pertanyaan $pertanyaan)
    {
        $pertanyaan->survei()->delete();

        $pertanyaan->delete();

        return redirect()->route('pertanyaan.index')->with('success', 'Pertanyaan berhasil dihapus!');
    }

    
}

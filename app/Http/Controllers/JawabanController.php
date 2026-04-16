<?php

namespace App\Http\Controllers;

use App\Models\Jawaban;
use App\Models\instrumenTeks;
use App\Models\TahunAkademikTeks;
use App\Models\NilaiInstrumenTeks;

use Illuminate\Http\Request;

class JawabanController extends Controller
{
    public function index(Request $request)
    {

        $jawaban = Jawaban::with(['tahunAkademikTeks', 'pertanyaanTeks'])->get();
        
        // Ambil data dari tabel tahun_akademik_teks
        $tahunAkademikTeks = TahunAkademikTeks::all();
    
        // Ambil data dari tabel instrumen_teks
        $instrumenTeks = InstrumenTeks::with('tahunAkademikTeks')->get();
    
        // Ambil data dari tabel nilai_instrumen_teks
        $nilaiInstrumenTeks = NilaiInstrumenTeks::with(['instrumenTeks', 'instrumenTeks.tahunAkademikTeks'])->get();
    
        // Query untuk jawaban dengan relasi
        $query = Jawaban::with([
            'nilaiInstrumenTeks',                             // Relasi dengan nilai_instrumen_teks
            'nilaiInstrumenTeks.instrumenTeks',              // Relasi ke instrumen_teks
            'nilaiInstrumenTeks.instrumenTeks.tahunAkademikTeks' // Relasi ke tahun_akademik_teks
        ]);
    
        // Filter berdasarkan request (opsional)
        if ($request->filled('tahun_akademik_teks_id')) {
            $query->whereHas('nilaiInstrumenTeks.instrumenTeks.tahunAkademikTeks', function ($subQuery) use ($request) {
                $subQuery->where('id', $request->tahun_akademik_teks_id);
            });
        }
    
        if ($request->filled('instrumen_teks_id')) {
            $query->whereHas('nilaiInstrumenTeks.instrumenTeks', function ($subQuery) use ($request) {
                $subQuery->where('id', $request->instrumen_teks_id);
            });
        }
    
        // Eksekusi query untuk mendapatkan data jawaban
        $jawaban = $query->get();
    
        // Kirim data ke view
        return view('jawaban.index', compact('jawaban', 'tahunAkademikTeks', 'instrumenTeks', 'nilaiInstrumenTeks'));
    }
            
    public function store(Request $request)
    {
        $request->validate(['jawaban' => 'required|string|max:255']);

        Jawaban::create([
            'jawaban' => $request->jawaban,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('jawaban.index')->with('success', 'Jawaban berhasil ditambahkan.');
    }

}

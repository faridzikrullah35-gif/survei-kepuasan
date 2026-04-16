<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\TahunAkademik;
use App\Models\SurveiTahun;
use Illuminate\Http\Request;

class TahunAkademikController extends Controller
{
    public function index(Request $request)
    {
        
        $tahunAkademik = TahunAkademik::orderBy('tahun', 'desc')->paginate(10);
       
        return view('tahun_akademik.index', compact('tahunAkademik'));

        // Mengambil semua data Tahun Akademik dengan paginasi dan pencarian
        $query = TahunAkademik::query();
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('tahun', 'LIKE', "%{$search}%")
                  ->orWhere('semester', 'LIKE', "%{$search}%")
                  ->orWhere('status', 'LIKE', "%{$search}%");
        }
    }

    public function create()
    {
        // Mengirim view form pembuatan Tahun Akademik
        return view('tahun_akademik.create');
    }

    public function store(Request $request)
    {
        // Validasi data input
        $request->validate([
            'tahun' => 'required|string|max:255', // Pastikan tahun tidak kosong
            'semester' => 'required|in:Ganjil,Genap',
            'status' => 'required|in:Aktif,Non-Aktif',
        ]);

        // Membuat tahun akademik baru dan menyimpannya
        $tahunAkademik = tahunAkademik::create([
            'tahun' => $request->tahun,
            'semester' => $request->semester,
            'status' => $request->status,
        ]);

        // Simpan data ke tabel survei_tahun
        SurveiTahun::create([
            'tahun_akademik_id' => $tahunAkademik->id,
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('tahun_akademik.index')->with('success', 'Tahun Akademik berhasil ditambahkan.');
    }

    public function show(TahunAkademik $tahunAkademik)
    {
        // Menampilkan detail Tahun Akademik
        return view('tahun_akademik.show', compact('tahunAkademik'));
    }

    public function edit($id)
    {
        $tahunAkademik = TahunAkademik::findOrFail($id);
        return view('tahun_akademik.edit', compact('tahunAkademik'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tahun' => 'required|string|max:255',
            'semester' => 'required|string',
            'status' => 'required|string',
        ]);

        $tahunAkademik = TahunAkademik::findOrFail($id);
        $tahunAkademik->update($request->all());

        return redirect()->route('tahun_akademik.index')->with('success', 'Data Tahun Akademik berhasil diperbarui.');
    }
    
    public function destroy(TahunAkademik $tahunAkademik)
    {
        $tahunAkademik->surveiTahun()->delete();

        // Menghapus data dari database
        $tahunAkademik->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('tahun_akademik.index')
                         ->with('success', 'Tahun Akademik berhasil dihapus.');
    }

}

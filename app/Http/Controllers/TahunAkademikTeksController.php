<?php

namespace App\Http\Controllers;

use App\Models\TahunAkademikTeks;
use App\Models\SurveiTahunTeks;

use Illuminate\Http\Request;

class TahunAkademikTeksController extends Controller
{
    public function index(Request $request)
    {
        $tahunAkademikTeks = TahunAkademikTeks::all();

        return view('TahunAkademik_teks.index', compact('tahunAkademikTeks'));
    }

    public function create()
    {
        return view('tahunAkademik_teks.create');
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
        $tahunAkademikTeks = tahunAkademikTeks::create([
            'tahun' => $request->tahun,
            'semester' => $request->semester,
            'status' => $request->status,
        ]);

        // Simpan data ke tabel survei_tahun
        SurveiTahunTeks::create([
            'tahun_akademik_teks_id' => $tahunAkademikTeks->id,
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('tahunAkademik-teks.index')->with('success', 'Tahun Akademik Kualitatif berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $tahunAkademikTeks = TahunAkademikTeks::findOrFail($id);
        return view('tahunAkademik_teks.edit', compact('tahunAkademikTeks'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tahun' => 'required|string|max:255',
            'semester' => 'required|string',
            'status' => 'required|string',
        ]);

        $tahunAkademikTeks = TahunAkademikTeks::findOrFail($id);
        $tahunAkademikTeks->update($request->all());

        return redirect()->route('tahunAkademik-teks.index')->with('success', 'Data Tahun Akademik Kualitatif berhasil diperbarui.');
    }

    public function destroy(TahunAkademikTeks $tahunAkademikTeks)
    {
        $tahunAkademikTeks->surveiTahunTeks()->delete();

        // Menghapus data dari database
        $tahunAkademikTeks->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('tahunAkademik-teks.index')
                         ->with('success', 'Tahun Akademik Kualitatif berhasil dihapus.');
    }

}

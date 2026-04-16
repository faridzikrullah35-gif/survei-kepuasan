<?php

namespace App\Http\Controllers;

use App\Models\SurveiTeks;
use App\Models\PertanyaanTeks;
use App\Models\SurveiTahunTeks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SurveiTeksController extends Controller
{
    public function index()
    {
        $surveiTeks = SurveiTeks::all();
        $surveiTahunTeks = SurveiTahunTeks::all();
        $roles = \App\Models\User::select('role')
        ->distinct()
        ->orderBy('role', 'asc')
        ->pluck('role');
        
        return view('survei-teks.index', compact('surveiTeks', 'surveiTahunTeks', 'roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        SurveiTeks::create($request->all());

        return redirect()->route('survei-teks.index')
            ->with('success', 'Survei Teks berhasil ditambahkan.');
    }

}

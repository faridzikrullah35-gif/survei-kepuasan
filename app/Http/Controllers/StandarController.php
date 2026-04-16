<?php

namespace App\Http\Controllers;

use App\Models\Standar;
use Illuminate\Http\Request;

class StandarController extends Controller
{
    public function edit()
    {
        $standar = Standar::all();
        return view('standar.edit-standar', compact('standar'));
    }

    public function updateFromTable(Request $request, $kode)
    {
        try {
            $standar = Standar::where('kode', $kode)->firstOrFail();
            $standar->nama = $request->input('nama');
            $standar->save();

            return response()->json([
                'success' => true,
                'message' => 'Nama standar berhasil diperbarui.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui standar.'
            ]);
        }
    }

    public function destroy($kode)
    {
        $standar = Standar::where('kode', $kode)->first();

        if ($standar) {
            $standar->delete();
            return redirect()->route('edit-standar.index')->with('success', 'Standar berhasil dihapus!');
        }

        return back()->withErrors(['standar' => 'Standar tidak ditemukan']);
    }
}

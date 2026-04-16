<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class LoginMahasiswaController extends Controller
{
    // Menampilkan halaman login berdasarkan role mahasiswa
    public function index()
    {
        // Jika sudah login, arahkan ke halaman sesuai role
        if (Auth::check()) {
            $role = Auth::user()->role;
            return view('login', compact('role')); // Gunakan file login-mahasiswa.blade.php
        }
        // Jika belum login, tampilkan halaman login
        return view('login'); // Gunakan file login-mahasiswa.blade.php
    }

    public function login(Request $request)
    {
        // Validasi input form login
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Coba autentikasi pengguna
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Jika berhasil login, redirect ke dashboard atau halaman lain
            return redirect()->route('login');
        }

        // Jika login gagal, kembali ke form login dengan pesan error
        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    // Metode untuk memperbarui role pengguna
    public function updateRole(Request $request)
    {
        // Validasi input
        $request->validate([
            'role' => 'required|in:mahasiswa,dosen,tenaga_kependidikan',
        ]);

        // Update role pengguna yang sedang login
        $user = Auth::user();
        $user->role = $request->role;
        $user->save();

        // Redirect kembali ke halaman login dengan pesan sukses
        return Redirect::route('dashboard')->with('success', 'Role berhasil diperbarui!');
    }
}

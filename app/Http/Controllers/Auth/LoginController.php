<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Menampilkan halaman login
    public function showLoginForm()
    {
        return view('pages.auth.auth-login');
    }

    // Menangani proses login
    public function login(Request $request)
    {
        // Validasi data login
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:4',
        ]);

        // Cek kredensial
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();

            // Ambil user yang sedang login
            $user = Auth::user();
            $password = $request->password;

            // Pengalihan berdasarkan role
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif (in_array($user->role, ['mahasiswa', 'dosen', 'tenaga_kependidikan'])) {
                return redirect()->route('user.dashboard');
            }

            // Jika role tidak dikenali
            Auth::logout();
            return abort(403, 'Unauthorized role.');
        }

        // Jika gagal login, kembali ke form login
        return redirect()->route('login')
            ->withErrors(['email' => 'Email atau password salah.'])
            ->withInput($request->only('email'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}

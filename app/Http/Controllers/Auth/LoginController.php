<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

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
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|min:4',
        ], [
            'login.required' => 'Email, NIK, NPM, atau NIDN wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 4 karakter.',
        ]);

        $login = trim($request->login);

        /*
        |--------------------------------------------------------------------------
        | Cari user berdasarkan Email / NIK / NPM / NIDN
        |--------------------------------------------------------------------------
        |
        | Saat ini data import lama menyimpan NIK pada kolom email.
        | Untuk data baru, NIK/NPM/NIDN bisa berada pada kolom masing-masing.
        |
        */
        $user = User::where(function ($query) use ($login) {
            $query->where('email', $login)
                ->orWhere('nik', $login)
                ->orWhere('npm', $login)
                ->orWhere('nidn', $login);
        })->first();

        // User tidak ditemukan
        if (!$user) {
            return back()
                ->withErrors([
                    'login' => 'Email, NIK, NPM, atau NIDN tidak ditemukan.'
                ])
                ->withInput($request->only('login'));
        }

        /*
        |--------------------------------------------------------------------------
        | Cek password
        |--------------------------------------------------------------------------
        */
        if (!Auth::attempt([
            'id' => $user->id,
            'password' => $request->password,
        ])) {
            return back()
                ->withErrors([
                    'login' => 'Password yang Anda masukkan salah.'
                ])
                ->withInput($request->only('login'));
        }

        // Regenerasi session
        $request->session()->regenerate();

        // Ambil user yang sedang login
        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | Redirect berdasarkan role
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'admin') {
            return redirect()->route('dashboard');
        }

        if (in_array($user->role, [
            'admin',
            'user',
            'mahasiswa',
            'dosen',
            'tenaga_kependidikan',
            'alumni',
            'dinas',
            'masyarakat',
        ])) {
            return redirect()->route('dashboard');
        }

        // Role tidak dikenali
        Auth::logout();

        abort(403, 'Unauthorized role.');
    }

    // Logout
    public function logout()
    {
        Auth::logout();

        return redirect('/login');
    }
}
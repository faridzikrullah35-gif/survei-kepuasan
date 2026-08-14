<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;

class LoginMahasiswaController extends Controller
{
    // Menampilkan halaman login
    public function index()
    {
        if (Auth::check()) {
            $role = Auth::user()->role;

            return view('login', compact('role'));
        }

        return view('login');
    }

    // Menangani proses login
    public function login(Request $request)
    {
        // Validasi input login
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|min:6',
        ], [
            'login.required' => 'Email, NIK, NPM, atau NIDN wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        $login = trim($request->login);

        /*
        |--------------------------------------------------------------------------
        | Cari user berdasarkan Email / NIK / NPM / NIDN
        |--------------------------------------------------------------------------
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
        ], $request->boolean('remember'))) {

            return back()
                ->withErrors([
                    'login' => 'Password yang Anda masukkan salah.'
                ])
                ->withInput($request->only('login'));
        }

        // Regenerasi session
        $request->session()->regenerate();

        /*
        |--------------------------------------------------------------------------
        | Redirect ke DashboardController
        |--------------------------------------------------------------------------
        |
        | DashboardController yang menentukan dashboard berdasarkan role.
        |
        */

        return redirect()->intended(route('dashboard'));
    }

    // Update role pengguna
    public function updateRole(Request $request)
    {
        $request->validate([
            'role' => 'required|in:mahasiswa,dosen,tenaga_kependidikan',
        ]);

        $user = Auth::user();

        $user->role = $request->role;
        $user->save();

        return Redirect::route('dashboard')
            ->with('success', 'Role berhasil diperbarui!');
    }
}
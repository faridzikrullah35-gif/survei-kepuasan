<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Models\User;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        // Tentukan judul berdasarkan role
        $roleTitles = [
            'admin' => 'Admin Profile',
            'mahasiswa' => 'Mahasiswa Profile',
            'dosen' => 'Dosen Profile',
            'tenaga_kependidikan' => 'Tenaga Kependidikan Profile',
            'user' => 'User Profile',
        ];

        $profileTitle = $roleTitles[$user->role] ?? 'User Profile';

        return view('layouts.profile', compact('user', 'profileTitle'));
    }

    public function update(Request $request, User $profile)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'password' => ['nullable', 'min:8', 'confirmed'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ];

        switch (auth()->user()->role) {
            case 'mahasiswa':
                $rules['npm'] = ['required', Rule::unique('users', 'npm')->ignore($profile->id)];
                $rules['fakultas'] = ['required', 'string', 'max:255'];
                $rules['prodi'] = ['required', 'string', 'max:255'];
                break;
            case 'dosen':
                $rules['nidn'] = ['required', Rule::unique('users', 'nidn')->ignore($profile->id)];
                break;
            case 'tenaga_kependidikan':
                $rules['nik'] = ['required', Rule::unique('users', 'nik')->ignore($profile->id)];
                break;
        }

        $request->validate($rules, [
            'npm.unique' => 'NPM ini sudah digunakan, masukkan npm yang benar.',
            'nidn.unique' => 'NIDN ini sudah terdaftar.',
            'nik.unique' => 'NIK ini sudah terdaftar.',
            'fakultas.required' => 'Fakultas wajib diisi.', 
            'prodi.required' => 'Program Studi wajib diisi.',
        ]);

        $profile->name = $request->name;

        if ($request->filled('password')) {
            $profile->password = Hash::make($request->password);
        }

        if ($request->hasFile('photo')) {
            if ($profile->photo && Storage::exists('photos/' . $profile->photo)) {
                Storage::delete('photos/' . $profile->photo);
            }
            $profile->photo = $request->file('photo')->store('photos', 'public');
        }

        switch (auth()->user()->role) {
            case 'mahasiswa':
                $profile->npm = $request->npm;
                $profile->fakultas = $request->fakultas;
                $profile->prodi = $request->prodi;
                break;
            case 'dosen':
                $profile->nidn = $request->nidn;
                break;
            case 'tenaga_kependidikan':
                $profile->nik = $request->nik;
                break;
        }

        try {
            $profile->save();
            return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->route('profile')->with('error', 'Terjadi kesalahan saat memperbarui profil.');
        }
    }

    public function updatePhoto(Request $request, $id)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi file gambar
        ]);
    
        $user = User::findOrFail($id);
    
        // Hapus foto lama jika ada
        if ($user->photo && Storage::exists($user->photo)) {
            Storage::delete($user->photo);
        }
    
        // Simpan foto baru
        $path = $request->file('photo')->store('photos', 'public');
        $user->photo = $path;
        $user->save();
    
        return redirect()->back()->with('success', 'Foto profil berhasil diperbarui.');
    }

    public function deletePhoto(User $profile)
    {
        if ($profile->photo && Storage::exists('photos/' . $profile->photo)) {
            Storage::delete('photos/' . $profile->photo);
            $profile->photo = null;
            $profile->save();
        }

        return redirect()->route('profile.index')->with('success', 'Foto profil berhasil dihapus.');
    }
}

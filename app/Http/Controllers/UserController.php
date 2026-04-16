<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = DB::table('users')
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->select('id', 'name', 'email', DB::raw('DATE_FORMAT(created_at, "%d %M %Y")
             as created_at'))
            ->orderBy('id', 'desc')
            ->paginate(15);
        return view('pages.users.index', compact('users'));
    }

    public function create()
    {
        return view('pages.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $request->validate([
            'role' => ['required', 'in:admin,mahasiswa,dosen,tenaga_kependidikan'], // Validasi role langsung dengan string
        ]);

        User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'roles' => $request['roles'],
            'handphone' => $request['handphone'],
            'address' => $request['address'],
            'role' => $request->role, // Simpan role sebagai string
        ]);

        return redirect(route('user.index'))->with('success', 'Data berhasil disimpan');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|confirmed|min:6',
            'role' => 'required|string',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('usermanagement')
                        ->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('user.index')->with('success', 'Delete User Successfully');
    }

    public function deletePhoto($id)
    {
        // Cari user berdasarkan ID
        $user = User::find($id);

        // Pastikan user ditemukan
        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }

        // Cek apakah user memiliki foto profil
        if ($user->photo) {
            // Hapus foto profil dari storage
            $photoPath = storage_path('app/public/' . $user->photo);
            
            if (file_exists($photoPath)) {
                unlink($photoPath); // Menghapus foto dari storage
            }

            // Set foto profil ke null
            $user->photo = null;
            $user->save();
        }

        return redirect()->back()->with('success', 'Foto profil berhasil dihapus');
    }
}

<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserManagementController extends Controller
{
    public function index()
    {
        $data = User::paginate(10);

        return view('admin.usermanagement', compact('data'));
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.show', compact('user'));
    }

    public function create()
    {
        // Ambil data role langsung dari kolom 'role' di tabel users
        $roles = Role::all(); // Mendapatkan daftar role yang unik dari tabel users
        return view('admin.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
            'role'     => 'required|string',
        ]);

        $input = $request->only('name', 'email');
        $input['password'] = Hash::make($request->password);
        $input['role'] = $request->role;

        $user = User::create($input);

        return redirect()->route('usermanagement.store')
                         ->with('success', 'User berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();

        return view('admin.edit', compact('user', 'roles'));
    }

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

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('usermanagement')
                         ->with('success', 'User berhasil dihapus.');
    }
}

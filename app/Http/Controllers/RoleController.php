<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::orderBy('id', 'asc')->get();
        return view('admin.role-index', compact('roles'));
    }

    // Menampilkan form untuk membuat role baru
    public function create()
    {
        $roles = Role::all()->pluck('name');
        return view('admin.role-create');
    }

    // Menyimpan role baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Role::create([
            'name' => $request->name,
        ]);

        return redirect()->route('role-index.index')->with('success', 'Role berhasil ditambahkan');
    }

    // Menampilkan form untuk mengedit role
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        return view('admin.role-edit', compact('role'));
    }

    // Memperbarui role yang ada
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            // tambahkan validasi lain sesuai kebutuhan
        ]);

        $role = Role::findOrFail($id);
        $role->update([
            'name' => $request->name,
            // tambahkan field lain sesuai kebutuhan
        ]);

        return redirect()->route('role-index.index')->with('success', 'Role berhasil diperbarui');
    }

    // Menghapus role
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('role-index.index')->with('success', 'Role berhasil dihapus');
    }
}

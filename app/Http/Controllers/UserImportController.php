<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;

class UserImportController extends Controller
{
    public function showForm()
    {
        return view('admin.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx'
        ]);

        Excel::import(new UsersImport, $request->file('file'));

        return redirect('/import-users')->with('success', 'Data berhasil diimport.');
    }
}

<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class UsersImport implements ToModel, WithChunkReading
{
    public function model(array $row)
    {
        if (empty($row[1])) {
            return null;
        }

        if (User::where('email', $row[1])->exists()) {
            return null;
        }

        return new User([
            'name'     => $row[0],
            'email'    => $row[1],
            'password' => Hash::make($row[2]),
            'role'     => $row[3],
        ]);
    }

    public function chunkSize(): int
    {
        return 100;
    }
}
<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Enums\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(50)->create();

        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],

            [
                'name' => 'admin',
                'email_verified_at' => now(),
                'password' => Hash::make('1234'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'name' => 'user',
                'email_verified_at' => now(),
                'password' => Hash::make('user123'), 
                'role' => 'user',
            ]
        );

    }
}
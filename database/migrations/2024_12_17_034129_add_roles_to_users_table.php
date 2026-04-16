<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            DB::table('users')->insert([
                ['role' => 'mahasiswa', 'name' => 'Unknown', 'email' => 'mahasiswa@example.com', 'password' => bcrypt('password_default')],
                ['role' => 'dosen', 'name' => 'Unknown', 'email' => 'dosen@example.com', 'password' => bcrypt('password_default')],
                ['role' => 'tenaga_kependidikan', 'name' => 'Unknown', 'email' => 'tenaga_kependidikan@example.com', 'password' => bcrypt('password_default')],
            ]);
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            DB::table('users')->where('role', 'mahasiswa')->delete();
            DB::table('users')->where('role', 'dosen')->delete();
            DB::table('users')->where('role', 'tenaga_kependidikan')->delete();
        });
    }

};

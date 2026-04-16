<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRoleToInstrumenTable extends Migration
{
    public function up()
    {
        Schema::table('instrumen', function (Blueprint $table) {
            $table->enum('role', ['admin', 'user', 'mahasiswa', 'dosen', 'tenaga_kependidikan'])->default('user')
        ->after('status'); // Menambahkan kolom role
        });
    }

    public function down()
    {
        Schema::table('instrumen', function (Blueprint $table) {
            $table->dropColumn('role'); // Menghapus kolom role jika rollback
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRoleToNilaiInstrumenTeksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nilai_instrumen_teks', function (Blueprint $table) {
            // Menambahkan kolom role dengan tipe enum
            $table->enum('role', ['admin', 'user', 'mahasiswa', 'dosen', 'tenaga_kependidikan'])->default('user')->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nilai_instrumen_teks', function (Blueprint $table) {
            // Menghapus kolom role
            $table->dropColumn('role');
        });
    }
}

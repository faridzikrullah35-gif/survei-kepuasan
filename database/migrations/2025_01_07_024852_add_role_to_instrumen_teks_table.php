<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRoleToInstrumenTeksTable extends Migration
{
    /**
     * Jalankan migration untuk menambahkan kolom role ke instrumen_teks.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('instrumen_teks', function (Blueprint $table) {
            $table->enum('role', ['admin', 'user', 'mahasiswa', 'dosen', 'tenaga_kependidikan'])
                  ->after('pertanyaan_teks_id'); // Menambahkan kolom role setelah pertanyaan_teks_id
        });        
    }

    /**
     * Rollback perubahan yang dilakukan oleh migration.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('instrumen_teks', function (Blueprint $table) {
            $table->dropColumn('role'); // Menghapus kolom role
        });
    }
}

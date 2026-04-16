<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTahunAkademikTeksIdToInstrumenTeksTable extends Migration
{
    /**
     * Menambahkan kolom tahun_akademik_teks_id ke tabel instrumen_teks.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('instrumen_teks', function (Blueprint $table) {
            $table->foreignId('tahun_akademik_teks_id')->after('pertanyaan_teks_id')->constrained('tahun_akademik_teks')
                ->onDelete('cascade'); // Menambahkan foreign key dengan penghapusan cascade
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
            // Hapus foreign key constraint terlebih dahulu
            $table->dropForeign(['tahun_akademik_teks_id']);
            
            // Hapus kolom setelah foreign key dihapus
            $table->dropColumn('tahun_akademik_teks_id');
        });
    }

}

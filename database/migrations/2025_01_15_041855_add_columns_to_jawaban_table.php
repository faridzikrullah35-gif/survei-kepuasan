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
        Schema::table('jawaban', function (Blueprint $table) {
            // Menambahkan kolom baru
            $table->unsignedBigInteger('tahun_akademik_teks_id')->after('instrumen_teks_id'); // Kolom untuk tahun akademik
            $table->unsignedBigInteger('pertanyaan_teks_id')->after('tahun_akademik_teks_id'); // Kolom untuk ID pertanyaan teks
            
            // Menambahkan foreign key jika diperlukan
            $table->foreign('tahun_akademik_teks_id')->references('id')->on('tahun_akademik_teks')->onDelete('cascade');
            $table->foreign('pertanyaan_teks_id')->references('id')->on('pertanyaan_teks')->onDelete('cascade');
        });
    }
    
    public function down()
    {
        Schema::table('jawaban', function (Blueprint $table) {
            // Hapus foreign key terlebih dahulu
            $table->dropForeign(['tahun_akademik_teks_id']);
            $table->dropForeign(['pertanyaan_teks_id']);
            
            // Menghapus kolom yang ditambahkan
            $table->dropColumn('tahun_akademik_teks_id');
            $table->dropColumn('pertanyaan_teks_id');
        });
    }

};    
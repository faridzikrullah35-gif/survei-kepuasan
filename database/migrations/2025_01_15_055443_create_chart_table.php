<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChartTable extends Migration
{
    public function up()
    {
        Schema::create('chart', function (Blueprint $table) {
            $table->id(); // kolom primary key
            $table->unsignedBigInteger('instrumen_id');
            $table->unsignedBigInteger('tahun_akademik_id');
            $table->unsignedBigInteger('pertanyaan_id');
            $table->unsignedBigInteger('nilai_instrumen_mahasiswa_id');
            $table->integer('nilai');
            $table->timestamps();

            // Menambahkan foreign key untuk relasi
            $table->foreign('instrumen_id')->references('id')->on('instrumen')->onDelete('cascade');
            $table->foreign('tahun_akademik_id')->references('id')->on('tahun_akademik')->onDelete('cascade');
            $table->foreign('pertanyaan_id')->references('id')->on('pertanyaan')->onDelete('cascade');
            $table->foreign('nilai_instrumen_mahasiswa_id')->references('id')->on('nilai_instrumen_mahasiswa')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('chart', function (Blueprint $table) {
            // Menghapus foreign key sebelum menghapus tabel
            $table->dropForeign(['instrumen_id']);
            $table->dropForeign(['tahun_akademik_id']);
            $table->dropForeign(['pertanyaan_id']);
            $table->dropForeign(['nilai_instrumen_mahasiswa_id']);
        });

        // Menghapus tabel chart
        Schema::dropIfExists('chart');
    }

}

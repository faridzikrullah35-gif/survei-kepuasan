<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveiTeksTable extends Migration
{
    /**
     * Jalankan migrasi untuk membuat tabel survei_teks.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survei_teks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pertanyaan_teks_id');
            $table->string('standar');
            $table->string('pertanyaan');
            $table->timestamps();

            // Relasi dengan tabel pertanyaan_teks
            $table->foreign('pertanyaan_teks_id')
                ->references('id')
                ->on('pertanyaan_teks')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Kembalikan perubahan dengan menghapus tabel survei_teks.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('survei_teks');
    }
};

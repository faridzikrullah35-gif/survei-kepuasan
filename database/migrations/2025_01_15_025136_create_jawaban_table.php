<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJawabanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jawaban', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('instrumen_teks_id');
            $table->unsignedBigInteger('nilai_instrumen_teks_id');
            $table->string('tahun');
            $table->string('standar');
            $table->text('pertanyaan');
            $table->text('jawaban');
            $table->timestamps();

            // Foreign keys
            $table->foreign('instrumen_teks_id')->references('id')->on('instrumen_teks')->onDelete('cascade');
            $table->foreign('nilai_instrumen_teks_id')->references('id')->on('nilai_instrumen_teks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jawaban');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNilaiTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('nilai', function (Blueprint $table) {
            $table->id(); // Menggunakan kolom id default
            $table->unsignedBigInteger('pertanyaan_id');
            $table->integer('nilai');
            $table->string('keterangan', 255);
            $table->timestamps();

            $table->foreign('pertanyaan_id')->references('id')->on('pertanyaan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai');
    }
};
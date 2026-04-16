<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNilaiInstrumenMahasiswaTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('nilai_instrumen_mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Relasi ke tabel users
            $table->string('role');
            $table->unsignedBigInteger('instrumen_id'); // Relasi ke tabel instrumen
            $table->integer('nilai');
            $table->text('keterangan')->nullable();
            $table->string('status')->default('belum_dijawab');
            $table->timestamps();

            // Relasi
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('instrumen_id')->references('id')->on('instrumen')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_instrumen_mahasiswa');
    }
}

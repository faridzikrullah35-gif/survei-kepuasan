<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTahunAkademik extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tahun_akademik', function (Blueprint $table) {
            $table->id();
            $table->string('tahun'); // Contoh: "2023/2024"
            $table->enum('semester', ['Ganjil', 'Genap']);
            $table->enum('status', ['Aktif', 'Non-Aktif'])->default('Non-Aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('tahun_akademik');
    }
}

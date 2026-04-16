<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instrumen_teks_non_aktif', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tahun_akademik_teks_id')->constrained('survei_tahun_teks')->onDelete('cascade');
            $table->foreignId('pertanyaan_teks_id')->constrained('survei_teks')->onDelete('cascade');
            $table->string('status')->default('Non-Aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('instrumen_teks_non_aktif');
    }
};

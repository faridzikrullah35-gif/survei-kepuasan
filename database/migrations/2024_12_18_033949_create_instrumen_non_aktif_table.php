<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstrumenNonAktifTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instrumen_non_aktif', function (Blueprint $table) {
            $table->id(); // ID untuk instrumen non-aktif
            $table->foreignId('tahun_akademik_id')->constrained('survei_tahun')->onDelete('cascade'); // Relasi dengan tabel tahun_akademik
            $table->foreignId('pertanyaan_id')->constrained('survei')->onDelete('cascade'); // Relasi dengan tabel survei
            $table->foreignId('nilai_id')->default(1)->constrained('nilai')->onDelete('cascade');
            $table->string('status')->default('Non-Aktif'); // Status instrumen
            $table->timestamps(); // Timestamps untuk created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('instrumen_non_aktif');
    }
}

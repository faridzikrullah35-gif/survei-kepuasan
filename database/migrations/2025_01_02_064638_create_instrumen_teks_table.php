<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstrumenTeksTable extends Migration
{
    /**
     * Jalankan migration untuk membuat tabel instrumen_teks.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instrumen_teks', function (Blueprint $table) {
            $table->id(); // Kolom ID utama
            $table->foreignId('pertanyaan_teks_id')->constrained()->onDelete('cascade'); // Relasi dengan tabel pertanyaan_teks
            $table->enum('status', ['terjawab', 'belum terjawab']); // Kolom status
            $table->timestamps(); // Timestamps (created_at dan updated_at)
        });
    }

    /**
     * Rollback perubahan yang dilakukan oleh migration.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('instrumen_teks');
    }
}

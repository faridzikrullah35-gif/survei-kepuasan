<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('standar', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique(); // Kode unik untuk standar
            $table->string('nama');          // Nama standar
            $table->timestamps();
        });

        // Seed data awal
        DB::table('standar')->insert([
            ['kode' => 'STANDAR_1_JATI_DIRI', 'nama' => 'STANDAR 1 JATI DIRI'],
            ['kode' => 'STANDAR_2_1_TATA_PAMONG', 'nama' => 'STANDAR 2.1 TATA PAMONG'],
            ['kode' => 'STANDAR_2_2_KERJASAMA', 'nama' => 'STANDAR 2.2 KERJASAMA'],
            ['kode' => 'STANDAR_3_KEMAHASISWAAN', 'nama' => 'STANDAR 3 KEMAHASISWAAN'],
            ['kode' => 'STANDAR_4_SUMBER_DAYA_MANUSIA', 'nama' => 'STANDAR 4 SUMBER DAYA MANUSIA'],
            ['kode' => 'STANDAR_6_PENDIDIKAN', 'nama' => 'STANDAR 6 PENDIDIKAN'],
            ['kode' => 'STANDAR_7_PENELITIAN', 'nama' => 'STANDAR 7 PENELITIAN'],
            ['kode' => 'STANDAR_8_PKM', 'nama' => 'STANDAR 8 PKM'],
            ['kode' => 'STANDAR_9_LUARAN', 'nama' => 'STANDAR 9 LUARAN'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('standar');
    }
};

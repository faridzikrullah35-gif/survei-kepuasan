<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJawabanToNilaiInstrumenTeksTable extends Migration
{
    /**
     * Menjalankan migration untuk menambah kolom jawaban.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nilai_instrumen_teks', function (Blueprint $table) {
            $table->string('status')->after('role');
            $table->text('jawaban')->after('status');  // Menambahkan kolom 'jawaban' setelah kolom 'status'
        });
    }

    /**
     * Membalikkan perubahan pada migration.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nilai_instrumen_teks', function (Blueprint $table) {
            $table->dropColumn(['jawaban', 'status']);  // Menghapus kolom 'jawaban' dan 'status' jika migration dibatalkan
        });
    }}

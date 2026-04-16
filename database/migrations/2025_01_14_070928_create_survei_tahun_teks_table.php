<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveiTahunTeksTable extends Migration
{
    public function up()
    {
        Schema::create('survei_tahun_teks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tahun_akademik_teks_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('survei_tahun_teks');
    }
}

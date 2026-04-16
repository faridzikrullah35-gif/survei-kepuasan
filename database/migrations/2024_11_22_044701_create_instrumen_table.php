<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstrumenTable extends Migration
{
    public function up()
    {
        Schema::create('instrumen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tahun_akademik_id')->constrained('tahun_akademik')->onDelete('cascade');
            $table->foreignId('pertanyaan_id')->constrained('pertanyaan')->onDelete('cascade');
            $table->foreignId('nilai_id')->default(1)->constrained('nilai')->onDelete('cascade');
            
            $table->string('status')->default('belum terjawab');
            
            $table->timestamps();
            
        });
    }

    public function down()
    {
        Schema::dropIfExists('instrumen');
    }
};

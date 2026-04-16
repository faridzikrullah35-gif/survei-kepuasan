<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveiTahunTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survei_tahun', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('tahun_akademik_id')->constrained('tahun_akademik')->onDelete('cascade'); // FK ke tahun akademik
            $table->timestamps(); // created_at dan updated_at otomatis
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('survei_tahun');
    }

};

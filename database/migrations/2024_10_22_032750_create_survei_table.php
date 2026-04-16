<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveiTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('survei', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pertanyaan_id');
            $table->string('standar')->default('tidak ditentukan');
            $table->text('pertanyaan'); 
            $table->timestamps();

        });
    }
    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('survei'); 
    }
}

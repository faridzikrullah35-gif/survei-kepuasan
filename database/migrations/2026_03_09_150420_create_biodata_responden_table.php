<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('biodata_responden', function (Blueprint $table) {

            $table->id();

            // relasi ke users
            $table->unsignedBigInteger('user_id');
            $table->string('role');

            // biodata
            $table->string('fakultas')->nullable();
            $table->string('prodi')->nullable();
            $table->string('semester')->nullable();
            $table->string('homebase')->nullable();
            $table->string('fakultas_unit')->nullable();

            $table->timestamps();

            // foreign key
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('biodata_responden');
    }
};
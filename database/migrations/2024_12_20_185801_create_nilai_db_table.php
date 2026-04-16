<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nilai_db', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique(); // Kode nilai, seperti 1, 2, 3, 4
            $table->string('keterangan')->nullable(); // Deskripsi nilai
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
        Schema::dropIfExists('nilai_db');
    }
};

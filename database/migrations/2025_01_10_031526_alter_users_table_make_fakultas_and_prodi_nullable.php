<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Mengubah kolom fakultas menjadi nullable
            $table->string('fakultas')->nullable()->change();

            // Mengubah kolom prodi menjadi nullable
            $table->string('prodi')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Mengembalikan kolom fakultas menjadi tidak nullable
            $table->string('fakultas')->nullable(false)->change();

            // Mengembalikan kolom prodi menjadi tidak nullable
            $table->string('prodi')->nullable(false)->change();
        });
    }
};

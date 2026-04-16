<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('fakultas')->after('npm'); // Kolom fakultas tidak nullable
            $table->string('prodi')->after('fakultas'); // Kolom prodi tidak nullable
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('fakultas');
            $table->dropColumn('prodi');
        });
    }
};

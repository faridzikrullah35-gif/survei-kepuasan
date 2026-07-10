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
        Schema::table('nilai_instrumen_teks', function (Blueprint $table) {
            $table->string('nilai_teks');
        });
    }

    public function down()
    {
        Schema::table('nilai_instrumen_teks', function (Blueprint $table) {
            $table->dropColumn('nilai_teks');
        });
    }
};

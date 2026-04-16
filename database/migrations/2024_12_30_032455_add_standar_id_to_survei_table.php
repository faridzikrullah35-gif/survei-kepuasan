<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStandarIdToSurveiTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('survei', function (Blueprint $table) {
            $table->unsignedBigInteger('standar_id')->after('pertanyaan_id'); // Menambahkan kolom standar_id setelah pertanyaan_id
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('survei', function (Blueprint $table) {
            $table->dropColumn('standar_id'); // Hapus kolom standar_id jika rollback
        });
    }
}

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
        Schema::table('nilai', function (Blueprint $table) {
            $table->unsignedBigInteger('instrumen_id')->nullable()->after('pertanyaan_id');
        });
    }
    
    public function down()
    {
        Schema::table('nilai', function (Blueprint $table) {
            $table->dropColumn('instrumen_id');
        });
    }
    
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('biodata_responden', function (Blueprint $table) {
            $table->string('unit')->nullable()->after('fakultas_unit');
            $table->string('sub_unit')->nullable()->after('unit');
        });
    }

    public function down(): void
    {
        Schema::table('biodata_responden', function (Blueprint $table) {
            $table->dropColumn(['unit', 'sub_unit']);
        });
    }
};
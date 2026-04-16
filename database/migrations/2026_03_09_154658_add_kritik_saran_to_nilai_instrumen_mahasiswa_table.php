<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('nilai_instrumen_mahasiswa', function (Blueprint $table) {
            $table->text('kritik_saran')->nullable()->after('keterangan');
        });
    }

    public function down(): void
    {
        Schema::table('nilai_instrumen_mahasiswa', function (Blueprint $table) {
            $table->dropColumn('kritik_saran');
        });
    }
};
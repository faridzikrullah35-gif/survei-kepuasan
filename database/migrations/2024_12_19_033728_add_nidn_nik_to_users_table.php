<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNidnNikToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('npm')->default('')->after('email');

            $table->string('nidn')->default('')->after('npm');

            $table->string('nik')->default('')->after('nidn');

        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Menghapus kolom nidn dan nik
            $table->dropColumn(['nidn', 'nik']);
        });
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NilaiDBSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('nilai_db')->insert([
            ['kode' => '1', 'keterangan' => 'Sangat Buruk'],
            ['kode' => '2', 'keterangan' => 'Buruk'],
            ['kode' => '3', 'keterangan' => 'Baik'],
            ['kode' => '4', 'keterangan' => 'Sangat Baik'],
        ]);
    }
}
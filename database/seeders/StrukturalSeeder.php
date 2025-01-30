<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StrukturalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['nama_struktural' => 'Dekan Fakultas'],
            ['nama_struktural' => 'Bidang Akademik S1'],
            ['nama_struktural' => 'Bidang Akademik Profesi'],
            ['nama_struktural' => 'Bidang Administrasi Umum dan Keuangan'],
            ['nama_struktural' => 'Bidang Kemahasiswaan'],
            ['nama_struktural' => 'Laboratorium Psikologi']
        ];

        DB::table('struktural')->insert($data);
    }
}

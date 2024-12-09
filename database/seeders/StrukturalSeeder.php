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
            ['nama_struktural' => 'Wakil Dekan I'],
            ['nama_struktural' => 'Wakil Dekan II'],
            ['nama_struktural' => 'Wakil Dekan III'],
            ['nama_struktural' => 'Ketua Prodi S1'],
            ['nama_struktural' => 'Sekretaris Prodi S1'],
            ['nama_struktural' => 'Ketua Prodi Profesi'],
            ['nama_struktural' => 'Sekretaris Prodi Profesi'],
            ['nama_struktural' => 'Laboratorium Psikologi'],
            ['nama_struktural' => 'Kasie Akademik Fakultas'],
            ['nama_struktural' => 'Kasie Administrasi Umum dan Keuangan'],
            ['nama_struktural' => 'Kasie Kemahasiswaan'],
        ];

        DB::table('struktural')->insert($data);
    }
}

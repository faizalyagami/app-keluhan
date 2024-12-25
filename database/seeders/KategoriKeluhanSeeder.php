<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriKeluhanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['nama_kategori_keluhan' => "Pelayanan Tenaga Kependidikan"],
            ['nama_kategori_keluhan' => "Administrasi dan Keuangan"],
            ['nama_kategori_keluhan' => "Kemahasiswaan"],
            ['nama_kategori_keluhan' => "Pelayanan Akademik"],
            ['nama_kategori_keluhan' => "Sarana dan Prasarana"],
            ['nama_kategori_keluhan' => "Laboratorium"],
        ];
        DB::table('kategori_keluhan')->insert($data);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Petugas::create([
            'nama_petugas'  => 'Administrator',
            'username'  => 'admin',
            'telp' => '08174882661',
            'password'  => bcrypt('12345678'),
            'roles' => 'admin'
        ]);
    }
}

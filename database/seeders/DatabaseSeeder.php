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
            'telp' => '628174882661',
            'password'  => bcrypt('12345678'),
            'roles' => 'admin'
        ]);

        Mahasiswa::create([
            'npm' => '10050024000',
            'name' => 'Faisal',
            'email' => 'faizalyagami@gmail.com',
            'email_verified_at' => now(),
            'username' => 'faisalabdillah',
            'jenis_kelamin' => 'Laki-laki',
            'password' => bcrypt('password'),
            'telp' => '628174882661',
            'alamat' => 'Bandung'
        ]);
    }
}

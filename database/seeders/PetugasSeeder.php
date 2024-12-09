<?php

namespace Database\Seeders;

use App\Models\Petugas;
use Illuminate\Database\Seeder;

class PetugasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $petugasData = [
            [
                'nama_petugas'  => 'Dr. Dewi Sartika, M.Si',
                'username'  => 'D940198',
                'telp' => '08122021514',
                'password'  => bcrypt('12345678'),
                'roles' => 'petugas',
                'id_struktural' => 1
            ],
            [
                'nama_petugas'  => 'Ali Mubarak, S.Psi., M.Psi.',
                'username'  => 'D070465',
                'telp' => '081221820024',
                'password'  => bcrypt('12345678'),
                'roles' => 'petugas',
                'id_struktural' => 2
            ],
            [
                'nama_petugas'  => 'Dr. Lilim Halimah, BHSc., MHSPY.',
                'username'  => 'D040388',
                'telp' => '087821295500',
                'password'  => bcrypt('12345678'),
                'roles' => 'petugas',
                'id_struktural' => 3
            ],
            [
                'nama_petugas'  => 'Suhana, S.Psi., M.Psi.',
                'username'  => 'D000329',
                'telp' => '081910066125',
                'password'  => bcrypt('12345678'),
                'roles' => 'petugas',
                'id_struktural' => 4
            ],
            [
                'nama_petugas'  => 'Dr. Siti Qodariah, M.Psi.',
                'username'  => 'D900112',
                'telp' => '0818228119',
                'password'  => bcrypt('12345678'),
                'roles' => 'petugas',
                'id_struktural' => 5
            ],
            [
                'nama_petugas'  => 'Farida Coralia, S.Psi., M.Psi.',
                'username'  => 'D080470',
                'telp' => '087824050920',
                'password'  => bcrypt('12345678'),
                'roles' => 'petugas',
                'id_struktural' => 6
            ],
            [
                'nama_petugas'  => 'Dr. Eneng Nurlaili Wangi, M.Psi.',
                'username'  => 'D970266',
                'telp' => '087822180071',
                'password'  => bcrypt('12345678'),
                'roles' => 'petugas',
                'id_struktural' => 7
            ],
            [
                'nama_petugas'  => 'Dr. Endah Nawangsih, Dra., M.Psi.',
                'username'  => 'D970265',
                'telp' => '087821971110',
                'password'  => bcrypt('12345678'),
                'roles' => 'petugas',
                'id_struktural' => 8
            ],
            [
                'nama_petugas'  => 'Rizka Hadian Permana, S.Psi., M.Psi.',
                'username'  => 'D150673',
                'telp' => '085294862549',
                'password'  => bcrypt('12345678'),
                'roles' => 'petugas',
                'id_struktural' => 9
            ],
            [
                'nama_petugas'  => 'Nida Hamidah, S.Psi',
                'username'  => 'A150337',
                'telp' => '081320200982',
                'password'  => bcrypt('12345678'),
                'roles' => 'petugas',
                'id_struktural' => 10
            ],
            [
                'nama_petugas'  => 'Nurmariam',
                'username'  => 'A910111',
                'telp' => '082216418470',
                'password'  => bcrypt('12345678'),
                'roles' => 'petugas',
                'id_struktural' => 11
            ],
            [
                'nama_petugas'  => 'Undang Kamaludin',
                'username'  => 'A020217',
                'telp' => '081322370437',
                'password'  => bcrypt('12345678'),
                'roles' => 'petugas',
                'id_struktural' => 12
            ]
        ];

        Petugas::insert($petugasData);
    }
}

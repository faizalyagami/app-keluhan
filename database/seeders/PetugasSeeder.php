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
                'password'  => bcrypt('D940198'),
                'roles' => 'petugas',
            ],
            [
                'nama_petugas'  => 'Ali Mubarak, S.Psi., M.Psi.',
                'username'  => 'D070465',
                'telp' => '081221820024',
                'password'  => bcrypt('D070465'),
                'roles' => 'petugas',
            ],
            [
                'nama_petugas'  => 'Dr. Lilim Halimah, BHSc., MHSPY.',
                'username'  => 'D040388',
                'telp' => '087821295500',
                'password'  => bcrypt('D040388'),
                'roles' => 'petugas',
            ],
            [
                'nama_petugas'  => 'Suhana, S.Psi., M.Psi.',
                'username'  => 'D000329',
                'telp' => '081910066125',
                'password'  => bcrypt('D000329'),
                'roles' => 'petugas',
            ],
            [
                'nama_petugas'  => 'Dr. Siti Qodariah, M.Psi.',
                'username'  => 'D900112',
                'telp' => '0818228119',
                'password'  => bcrypt('D900112'),
                'roles' => 'petugas',
            ],
            [
                'nama_petugas'  => 'Farida Coralia, S.Psi., M.Psi.',
                'username'  => 'D080470',
                'telp' => '087824050920',
                'password'  => bcrypt('D080470'),
                'roles' => 'petugas',
            ],
            [
                'nama_petugas'  => 'Dr. Eneng Nurlaili Wangi, M.Psi.',
                'username'  => 'D970266',
                'telp' => '087822180071',
                'password'  => bcrypt('D970266'),
                'roles' => 'petugas',
            ],
            [
                'nama_petugas'  => 'Dr. Endah Nawangsih, Dra., M.Psi.',
                'username'  => 'D970265',
                'telp' => '087821971110',
                'password'  => bcrypt('D970265'),
                'roles' => 'petugas',
            ],
            [
                'nama_petugas'  => 'Rizka Hadian Permana, S.Psi., M.Psi.',
                'username'  => 'D150673',
                'telp' => '085294862549',
                'password'  => bcrypt('D150673'),
                'roles' => 'petugas',
            ],
            [
                'nama_petugas'  => 'Nida Hamidah, S.Psi',
                'username'  => 'A150337',
                'telp' => '081320200982',
                'password'  => bcrypt('A150337'),
                'roles' => 'petugas',
            ],
            [
                'nama_petugas'  => 'Nurmariam',
                'username'  => 'A910111',
                'telp' => '082216418470',
                'password'  => bcrypt('A910111'),
                'roles' => 'petugas',
            ],
            [
                'nama_petugas'  => 'Undang Kamaludin',
                'username'  => 'A020217',
                'telp' => '081322370437',
                'password'  => bcrypt('A020217'),
                'roles' => 'petugas',
            ]
        ];

        // Insert petugas data
        Petugas::insert($petugasData);

        $aliMubarak = Petugas::where('username', 'D070465')->first();
        $aliMubarak->struktural()->attach([2, 3]);

        $nidaHamidah = Petugas::where('username', 'A150337')->first();
        $nidaHamidah->struktural()->attach([2, 3]);
    }
}

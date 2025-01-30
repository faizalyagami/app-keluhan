<?php

namespace Database\Seeders;

use App\Models\Petugas;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
                'telp' => '628122021514',
                'password'  => bcrypt('D940198'),
                'roles' => 'petugas',
            ],
            [
                'nama_petugas'  => 'Ali Mubarak, S.Psi., M.Psi.',
                'username'  => 'D070465',
                'telp' => '6281221820024',
                'password'  => bcrypt('D070465'),
                'roles' => 'petugas',
            ],
            [
                'nama_petugas'  => 'Dr. Lilim Halimah, BHSc., MHSPY.',
                'username'  => 'D040388',
                'telp' => '6287821295500',
                'password'  => bcrypt('D040388'),
                'roles' => 'petugas',
            ],
            [
                'nama_petugas'  => 'Suhana, S.Psi., M.Psi.',
                'username'  => 'D000329',
                'telp' => '6281910066125',
                'password'  => bcrypt('D000329'),
                'roles' => 'petugas',
            ],
            [
                'nama_petugas'  => 'Dr. Siti Qodariah, M.Psi.',
                'username'  => 'D900112',
                'telp' => '62818228119',
                'password'  => bcrypt('D900112'),
                'roles' => 'petugas',
            ],
            [
                'nama_petugas'  => 'Farida Coralia, S.Psi., M.Psi.',
                'username'  => 'D080470',
                'telp' => '6287824050920',
                'password'  => bcrypt('D080470'),
                'roles' => 'petugas',
            ],
            [
                'nama_petugas'  => 'Dr. Eneng Nurlaili Wangi, M.Psi.',
                'username'  => 'D970266',
                'telp' => '6287822180071',
                'password'  => bcrypt('D970266'),
                'roles' => 'petugas',
            ],
            [
                'nama_petugas'  => 'Dr. Endah Nawangsih, Dra., M.Psi.',
                'username'  => 'D970265',
                'telp' => '6287821971110',
                'password'  => bcrypt('D970265'),
                'roles' => 'petugas',
            ],
            [
                'nama_petugas'  => 'Rizka Hadian Permana, S.Psi., M.Psi.',
                'username'  => 'D150673',
                'telp' => '6285294862549',
                'password'  => bcrypt('D150673'),
                'roles' => 'petugas',
            ],
            [
                'nama_petugas'  => 'Nida Hamidah, S.Psi',
                'username'  => 'A150337',
                'telp' => '6281320200982',
                'password'  => bcrypt('A150337'),
                'roles' => 'petugas',
            ],
            [
                'nama_petugas'  => 'Nurmariam',
                'username'  => 'A910111',
                'telp' => '6282216418470',
                'password'  => bcrypt('A910111'),
                'roles' => 'petugas',
            ],
            [
                'nama_petugas'  => 'Undang Kamaludin',
                'username'  => 'A020217',
                'telp' => '6281322370437',
                'password'  => bcrypt('A020217'),
                'roles' => 'petugas',
            ],
            [
                'nama_petugas'  => 'Noer Fitriani, S.Psi',
                'username'  => 'A180405',
                'telp' => '628987955393',
                'password'  => bcrypt('A180405'),
                'roles' => 'petugas',
            ]
        ];

        // Insert petugas data
        Petugas::insert($petugasData);

        // Menghubungkan Petugas dengan id_struktural sesuai data
        $petugas = Petugas::where('username', 'D940198')->first();
        $petugas->struktural()->attach(1);  // Dr. Dewi Sartika, M.Si

        $petugas = Petugas::where('username', 'D070465')->first();
        $petugas->struktural()->attach([2, 3]);  // Ali Mubarak, S.Psi., M.Psi.

        $petugas = Petugas::where('username', 'D040388')->first();
        $petugas->struktural()->attach(4);  // Dr. Lilim Halimah, BHSc., MHSPY.

        $petugas = Petugas::where('username', 'D000329')->first();
        $petugas->struktural()->attach(5);  // Suhana, S.Psi., M.Psi.

        $petugas = Petugas::where('username', 'D900112')->first();
        $petugas->struktural()->attach(2);  // Dr. Siti Qodariah, M.Psi.

        $petugas = Petugas::where('username', 'D080470')->first();
        $petugas->struktural()->attach(2);  // Farida Coralia, S.Psi., M.Psi.

        $petugas = Petugas::where('username', 'D970266')->first();
        $petugas->struktural()->attach(3);  // Dr. Eneng Nurlaili Wangi, M.Psi.

        $petugas = Petugas::where('username', 'D970265')->first();
        $petugas->struktural()->attach(3);  // Dr. Endah Nawangsih, Dra., M.Psi.

        $petugas = Petugas::where('username', 'D150673')->first();
        $petugas->struktural()->attach(6);  // Rizka Hadian Permana, S.Psi., M.Psi.

        $petugas = Petugas::where('username', 'A150337')->first();
        $petugas->struktural()->attach([2, 3]);  // Nida Hamidah, S.Psi

        $petugas = Petugas::where('username', 'A910111')->first();
        $petugas->struktural()->attach(4);  // Nurmariam

        $petugas = Petugas::where('username', 'A020217')->first();
        $petugas->struktural()->attach(5);  // Undang Kamaludin

        $petugas = Petugas::where('username', 'A180405')->first();
        $petugas->struktural()->attach(6);  // Noer Fitriani
    }
}

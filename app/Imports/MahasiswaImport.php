<?php

namespace App\Imports;

use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MahasiswaImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    // public function __construct()
    // {
    //     set_time_limit(300);
    // }

    public function model(array $row)
    {
        return new Mahasiswa([
            'npm' => $row['npm'],
            'name' => $row['name'],
            'email' => $row['email'],
            'username' => $row['username'],
            'jenis_kelamin' => $row['jenis_kelamin'],
            'telp' => $row['no_telp'],
            'alamat' => $row['alamat'],
            'email_verified_at' => now(),
            'password' => Hash::make($row['npm'])
        ]);
    }
}

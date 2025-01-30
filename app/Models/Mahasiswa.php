<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Mahasiswa extends Authenticatable
{
    use HasFactory;

    protected $table = 'mahasiswa';

    protected $primaryKey = 'npm';

    public $incrementing = false;

    protected $fillable = [
        'npm',
        'name',
        'email',
        'email_verified_at',
        'username',
        'jenis_kelamin',
        'password',
        'telp',
        'alamat',
        'rt',
        'rw',
        'kode_pos',
        'province_id',
        'regency_id',
        'district_id',
        'village_id',
    ];
}

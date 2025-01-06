<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Petugas extends Authenticatable
{
    use HasFactory;

    protected $primaryKey = 'id_petugas';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nama_petugas',
        'username',
        'password',
        'telp',
        'roles'
    ];

    protected $hidden = [
        'password'
    ];

    public function struktural()
    {
        return $this->belongsToMany(Struktural::class, 'petugas_struktural', 'id_petugas', 'id_struktural');
    }

    public function isStruktural()
    {
        return $this->roles === 'struktural';
    }

    public function isPetugas()
    {
        return $this->roles === 'petugas';
    }
}

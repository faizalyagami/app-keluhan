<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Struktural extends Model
{
    use HasFactory;

    protected $table = 'struktural';
    protected $primaryKey = 'id_struktural';
    protected $fillable = ['nama_struktural'];

    public function petugas()
    {
        return $this->belongsToMany(Petugas::class, 'petugas_struktural', 'id_struktural', 'id_petugas');
    }

    public function keluhan()
    {
        return $this->hasMany(Keluhan::class, 'id_struktural', 'id_struktural');
    }
}

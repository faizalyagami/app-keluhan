<?php

namespace App\Models;

use App\Models\Mahasiswa;
use App\Models\Struktural;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Keluhan extends Model
{
    use HasFactory;

    protected $table = 'keluhan';

    protected $primaryKey = 'id_keluhan';

    protected $fillable = [
        'tgl_keluhan',
        'npm',
        'id_struktural',
        'judul_keluhan',
        'isi_keluhan',
        'foto',
        'status',
    ];

    public function user()
    {
        return $this->hasOne(Mahasiswa::class, 'npm', 'npm');
    }

    public function struktural()
    {
        return $this->belongsTo(Struktural::class, 'id_struktural', 'id_struktural');
    }
}

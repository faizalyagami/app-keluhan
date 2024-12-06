<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keluhan extends Model
{
    use HasFactory;

    protected $table = 'keluhan';

    protected $primaryKey = 'id_keluhan';

    protected $fillable = [
        'tgl_keluhan',
        'npm',
        'judul_keluhan',
        'isi_keluhan',
        'foto',
        'status',
    ];

    public function user()
    {
        return $this->hasOne(Mahasiswa::class, 'npm', 'npm');
    }
}

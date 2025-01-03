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

    protected $attribbutes = [
        'status' => '0'
    ];

    protected $fillable = [
        'tgl_keluhan',
        'npm',
        'id_struktural',
        'kategori_keluhan',
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

    public function kategori()
    {
        return $this->belongsTo(KategoriKeluhan::class, 'kategori_keluhan', 'id_kategori_keluhan');
    }

    public function disposisi()
    {
        return $this->hasMany(Disposisi::class, 'id_struktural', 'id_struktural')
            ->whereNotNull('id_keluhan');
    }
}

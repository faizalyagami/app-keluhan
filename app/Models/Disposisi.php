<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disposisi extends Model
{
    use HasFactory;

    protected $table = 'disposisi';
    protected $fillable = ['id_keluhan', 'id_struktural', 'pesan'];

    public function keluhan()
    {
        return $this->belongsTo(Keluhan::class, 'id_keluhan', 'id_keluhan');
    }

    public function struktural()
    {
        return $this->belongsTo(Struktural::class, 'id_struktural', 'id_keluhan');
    }
}

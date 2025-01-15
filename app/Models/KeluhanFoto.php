<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeluhanFoto extends Model
{
    protected $table = 'keluhan_foto';
    protected $fillable = ['id_keluhan', 'path'];

    public function keluhan()
    {
        return $this->belongsTo(Keluhan::class, 'id_keluhan');
    }
}

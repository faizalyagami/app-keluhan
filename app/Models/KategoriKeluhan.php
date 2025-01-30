<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriKeluhan extends Model
{
    use HasFactory;
    protected $table = 'kategori_keluhan';
    protected $primaryKey = 'id_kategori_keluhan';
    protected $fillable = ['kategori_keluhan'];

    public function keluhan()
    {
        return $this->hasMany(Keluhan::class, 'id_kategori_keluhan', 'id_kategori_keluhan');
    }
}

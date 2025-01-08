<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluasi extends Model
{
    use HasFactory;

    protected $table = 'evaluasi';
    protected $primaryKey = 'id_evaluasi';

    protected $fillable = [
        'id_keluhan',
        'isi_evaluasi'
    ];

    public function keluhan()
    {
        return $this->belongsTo(Keluhan::class, 'id_keluhan', 'id_keluhan');
    }
}

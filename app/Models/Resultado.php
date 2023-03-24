<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resultado extends Model
{
    use HasFactory;

    protected $fillable = [
        'carrera_id',
        'piloto_id',
        'puntosObtenidos'
    ];

    public function piloto() {
        return $this->belongsTo(Piloto::class);
    }

    public function carrera()
    {
        return $this->belongsTo(Carrera::class);
    }
}

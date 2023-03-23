<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombreCircuito',
        'descripcionCircuito',
        'image',
        'piloto_id'
    ];

    public function pilotos() {
        return $this->belongsToMany(Piloto::class);
    }

    public  function resultados() {
        return $this->hasMany(Resultado::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Piloto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'apellido',
        'pais',
        'numCoche',
        'image',
        'escuderia_id'
    ];
}

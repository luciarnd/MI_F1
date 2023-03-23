<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Escuderia extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'director',
        'motorUsado',
        'image'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'direccion',
        'fecha',
        'precio_total',
        'localidad',
        'zip',
        'personaReceptora'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function detallePedido() {
        return $this->hasOne(DetallePedido::class);
    }
}

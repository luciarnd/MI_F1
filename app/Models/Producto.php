<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $fillable = [
        'precio',
        'marca',
        'nombre',
        'descripcion',
        'stock'
    ];

    public function pedido() {
        return $this->hasOne(Pedido::class);
    }

    public function images() {
        return $this->hasMany(Image::class);
    }

    public function carrito() {
        return $this->hasOne(Carrito::class);
    }
}

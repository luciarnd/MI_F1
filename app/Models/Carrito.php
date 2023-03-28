<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
    use HasFactory;

    protected $fillable = [
        'cantidad',
        'user_id',
        'producto_id'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function productos() {
        return $this->belongsToMany(Producto::class);
    }
}

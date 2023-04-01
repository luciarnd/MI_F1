<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePedido extends Model
{
    protected $table = 'pedido_producto';

    protected $fillable = [
        'producto_id',
        'pedido_id',
        'cantidad'
    ];
    use HasFactory;

    public function pedidos() {
        return $this->belongsToMany(Pedido::class);
    }
}

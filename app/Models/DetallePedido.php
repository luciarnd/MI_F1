<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePedido extends Model
{
    use HasFactory;

    protected $table = 'pedido_producto';

    protected $fillable = [
        'pedido_id',
        'producto_id',
        'cantidad'
    ];

    public function pedido() {
        return $this->belongsTo(Pedido::class);
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Carrito;
use App\Models\DetallePedido;
use App\Models\Pedido;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Validator;

class PedidoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        return Pedido::all();
    }

    public function indexByUser() {
        $user = Auth::user()->id;
        $pedidos = Pedido::where('user_id', '=', $user)->get();
        $misPedidosConProducto = [];
        foreach ($pedidos as $pedido) {
            $pedido->productos;
            $misPedidosConProducto[] = $pedido;
        }
        return $misPedidosConProducto;
    }
    public function show($id) {
        $pedido = Pedido::findOrFail($id);

        return response()->json(['pedido' => $pedido], 200);
    }

    public function store(Request $request) {
        $validate = Validator::make($request->all(), [
            'direccion' => 'required|string',
            'localidad' => 'required|string',
            'zip' => 'required|string',
            'personaReceptora' => 'required|string'
        ]);

        if($validate->fails()) {
            return response()->json(['error' => 'Hubo un error al hacer el producto.'], 500);
        }

        $input = $request->all();
        $user = Auth::user()->id;

        $pedido = Pedido::create([
            'direccion' => $request->direccion,
            'fecha' => \date('d/m/Y'),
            'localidad' => $request->localidad,
            'zip' => $request->zip,
            'personaReceptora' => $request->personaReceptora,
            'user_id' => $user
        ]);
        $pedido->save();

        $carrito = Carrito::with('producto')->where('user_id', '=', $user)->get();
        $precio_total = 0;
        foreach ($carrito as $producto) {
            $productoABuscar = Producto::findOrFail($producto->producto->id);
            $cantidad = $producto->cantidad;
            $productoABuscar->stock = $productoABuscar->stock - $cantidad;
            $productoABuscar->save();
            $precio_total += $cantidad * $productoABuscar->precio;

            $detallepedido = DetallePedido::create([
                'pedido_id' => $pedido->id,
                'producto_id' => $productoABuscar->id,
                'cantidad' => $cantidad

            ]);
            $detallepedido->save();
        }
        $pedido->precio_total = $precio_total;
        $pedido->save();
        return response()->json(['success' => 'Pedido guardado con exito', 'pedido' => $pedido, 'detalle' => $detallepedido], 200);
    }

    public function update(Request $request, $id) {
        $pedido = Pedido::findOrFail($id);

        $input = $request->all();
        $pedido->update($input);

        return response()->json(['success' => 'Pedido editado con exito', 'pedido' => $pedido], 200);
    }

    public function delete($id) {
        $pedido = Pedido::findOrFail($id);
        $pedido->delete();
        return response()->json(['success' => 'Pedido borrado con exito', 'pedido' => $pedido], 200);
    }
}

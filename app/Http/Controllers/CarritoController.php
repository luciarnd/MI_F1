<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Carrito;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CarritoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function indexByUser() {
        $user_id = Auth::user()->id;
        return Carrito::with('producto')->where('user_id', '=', $user_id)->get();
    }

    public function store(Request $request) {
        $validate = Validator::make($request->all(), [
            'producto_id' => 'required|int',
            'cantidad' => 'required|int',
        ]);

        if($validate->fails()) {
            return response()->json(['error' => 'Hubo un error al añadir al carrito.'], 500);
        }

        $input = $request->all();

        $carrito = new Carrito($input);
        $user = Auth::user();
        $carrito->user_id = $user->id;
        $carrito->save();
        return response()->json(['success' => 'Carrito guardado con exito', 'carrito' => $carrito], 200);
    }

    public function update(Request $request, Producto $producto) {
        $user = Auth::user()->id;
        $carrito = Carrito::where('user_id', '=', $user)->where('producto_id', '=', $producto->id)->limit(1);
        $input = $request->all();
        $carrito->update($input);

        return response()->json(['success' => 'Cantidad editada con exito'], 200);
    }

    public function deleteProducto(Producto $producto) {
        $user = Auth::user()->id;
        $carrito = Carrito::where('user_id', '=', $user)->where('producto_id', '=', $producto->id)->limit(1);
        $carrito->delete();
        return response()->json(['success' => 'Producto borrado del carrito con exito'], 200);
    }

    public function deleteCarrito() {
        $user = Auth::user()->id;
        $carrito = Carrito::where('user_id', '=', $user);
        $carrito->delete();
    }
}

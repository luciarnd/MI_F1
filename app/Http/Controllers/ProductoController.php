<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Piloto;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index','show']]);
    }

    public function index() {
        return Producto::with('images')->get();
    }

    public function show($id) {
        $producto = Producto::findOrFail($id);
        $producto->images;

        return response()->json(['producto' => $producto], 200);
    }
    public function store(Request $request) {
        $validate = Validator::make($request->all(), [
            'nombre' => 'required|string',
            'descripcion' => 'required|string',
            'marca' => 'required|string',
            'stock' => 'required|int',
            'precio' => 'required'
        ]);

        if($validate->fails()) {
            return response()->json(['error' => 'Hubo un error al almacenar el producto.'], 500);
        }

        $input = $request->all();

        $producto = Producto::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'marca' => $request->marca,
            'stock' => $request->stock,
            'precio' => $request->precio
        ]);
        $producto->save();

        if($files = $request->images) {
            foreach ($files as $file) {
                $name = $file->getClientOriginalName();
                Storage::put('public/productos/' . $name, file_get_contents($file->getRealPath()));
                $image = new Image();
                $image->nombre = $name;
                $image->producto_id = $producto->id;
                $image->save();
            }
        }
        return response()->json(['success' => 'Producto guardado con exito', 'producto' => $producto], 200);
    }

    public function update(Request $request, $id) {
        $producto = Producto::findOrFail($id);

        $input = $request->all();
        $producto->update($input);

        return response()->json(['success' => 'Producto editado con exito', 'producto' => $producto], 200);
    }

    public function delete($id) {
        $producto = Producto::findOrFail($id);
        $producto->delete();
        return response()->json(['success' => 'Producto borrado con exito', 'producto' => $producto], 200);
    }
}

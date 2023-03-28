<?php

namespace App\Http\Controllers;

use App\Models\Escuderia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class EscuderiaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index','show']]);
    }
    public function index() {
        return Escuderia::all();
    }

    public function show($id) {
        $escuderia = Escuderia::findOrFail($id);

        return response()->json(['escuderia' => $escuderia], 200);
    }
    public function store(Request $request) {
        $validate = Validator::make($request->all(), [
            'nombre' => 'required|string',
            'director' => 'required|string',
            'motorUsado' => 'required|string',
            'image' => 'required'
        ]);

        if($validate->fails()) {
            return response()->json(['error' => 'Hubo un error al almacenar la escuderia.'], 500);
        }

        $input = $request->all();

        if($file = $request->file('image')) {
            $name = $file->getClientOriginalName();
            Storage::put('public/escuderias/' . $name, file_get_contents($file->getRealPath()));
            $input['image'] = $name;
        }

        $escuderia = new Escuderia($input);
        $escuderia->image = $input['image'];
        $escuderia->save();
        return response()->json(['success' => 'Escuderia guardada con exito', 'escuderia' => $escuderia], 200);
    }

    public function update(Request $request, $id) {
        $escuderia = Escuderia::findOrFail($id);

        $input = $request->all();
        $escuderia->update($input);

        if($file = $request->file('image')) {
            $name = $file->getClientOriginalName();
            Storage::put('public/escuderias/' . $name, file_get_contents($file->getRealPath()));
            $escuderia->image = $name;
            $escuderia->save();
        }

        return response()->json(['success' => 'Escuderia editada con exito', 'escuderia' => $escuderia], 200);
    }

    public function delete($id) {
        $escuderia = Escuderia::findOrFail($id);
        $escuderia->delete();
        return response()->json(['success' => 'Escudería borrada con exito', 'escudería' => $escuderia], 200);
    }
}

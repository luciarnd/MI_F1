<?php

namespace App\Http\Controllers;

use App\Models\Escuderia;
use App\Models\Piloto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PilotoController extends Controller
{

    public function index() {
        return Piloto::with('escuderia')->get();
    }

    public function show($id) {
        $piloto = Piloto::findOrFail($id);
        $piloto->escuderia;

        return response()->json(['piloto' => $piloto], 200);
    }

    public function store(Request $request) {
        $validate = Validator::make($request->all(), [
            'nombre' => 'required|string',
            'apellido' => 'required|string',
            'pais' => 'required|string',
            'numCoche' => 'required|string',
            'escuderia_id' => 'required|int',
            'image' => 'required'
        ]);

        if($validate->fails()) {
            return response()->json(['error' => 'Hubo un error al almacenar el piloto.'], 500);
        }

        $input = $request->all();

        if($file = $request->file('image')) {
            $name = $file->getClientOriginalName();
            Storage::put('public/pilotos/' . $name, file_get_contents($file->getRealPath()));
            $input['image'] = $name;
        }

        $piloto = new Piloto($input);
        $escuderia = Escuderia::findOrFail($input['escuderia_id']);
        $piloto->image = $input['image'];
        $piloto->escuderia()->associate($escuderia);
        $piloto->save();
        return response()->json(['success' => 'Piloto guardado con exito', 'piloto' => $piloto], 200);
    }

    public function update(Request $request, $id) {
        $piloto = Piloto::findOrFail($id);

        $input = $request->all();
        $piloto->update($input);

        if($file = $request->file('image')) {
            $name = $file->getClientOriginalName();
            Storage::put('public/pilotos/' . $name, file_get_contents($file->getRealPath()));
            $piloto->image = $name;
            $piloto->save();
        }

        return response()->json(['success' => 'Piloto editado con exito', 'piloto' => $piloto], 200);
    }

    public function delete($id) {
        $piloto = Piloto::findOrFail($id);
        $piloto->delete();
        return response()->json(['success' => 'Piloto borrado con exito', 'piloto' => $piloto], 200);
    }
}

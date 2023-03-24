<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use App\Models\Piloto;
use App\Models\Resultado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ResultadoController extends Controller
{
    public function index() {
        return Resultado::with(['piloto', 'carrea'])->get();
    }

    public function show($id) {
        $resultado = Resultado::findOrFail($id);
        $resultado->piloto;
        $resultado->carrera;

        return response()->json(['resultado' => $resultado], 200);
    }

    public function showByCarrera($id) {
        $resultados = Resultado::with(['piloto', 'carrea'])->get();
        $resultadosCarrera = $resultados->where('carrera_id', '=', $id);

        return response()->json(['resultados' => $resultadosCarrera], 200);
    }

    public function store(Request $request) {
        $validate = Validator::make($request->all(), [
            'nombreCircuito' => 'required|string',
            'descripcionCircuito' => 'required|string',
            'piloto_id' => 'required|int',
            'image' => 'required'
        ]);

        if($validate->fails()) {
            return response()->json(['error' => 'Hubo un error al almacenar la carrera.'], 500);
        }

        $input = $request->all();

        if($file = $request->file('image')) {
            $name = $file->getClientOriginalName();
            Storage::put('public/carreras/' . $name, file_get_contents($file->getRealPath()));
            $input['image'] = $name;
        }

        $carrera = new Resultado($input);
        $pilotoVueltaRapida = Piloto::findOrFail($input['piloto_id']);
        $carrera->image = $input['image'];
        $carrera->piloto()->associate($pilotoVueltaRapida);
        $carrera->save();
        return response()->json(['success' => 'Carrera guardada con exito', 'carrera' => $carrera], 200);
    }

    public function update(Request $request, $id) {
        $carrera = Resultado::findOrFail($id);

        $input = $request->all();
        $carrera->update($input);

        if($file = $request->file('image')) {
            $name = $file->getClientOriginalName();
            Storage::put('public/carreras/' . $name, file_get_contents($file->getRealPath()));
            $carrera->image = $name;
            $carrera->save();
        }

        return response()->json(['success' => 'Carrera editada con exito', 'carrera' => $carrera], 200);
    }

    public function delete($id) {
        $carrera = Resultado::findOrFail($id);
        $carrera->delete();
        return response()->json(['success' => 'Carrera borrada con exito', 'carrera' => $carrera], 200);
    }
}

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
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index','showByCarrera']]);
    }

    public function index() {
        return Resultado::with(['piloto', 'carrera'])->get();
    }

    public function showByCarrera($id) {
        $resultados = Resultado::with(['piloto', 'carrera']);
        $resultadosCarrera = $resultados->where('carrera_id', '=', $id)->orderBy('puntosObtenidos', 'desc')->orderBy('created_at', 'asc')->get();

        return response()->json(['resultados' => $resultadosCarrera], 200);
    }

    public function store(Request $request) {
        $validate = Validator::make($request->all(), [
            'carrera_id' => 'required|int',
            'puntosObtenidos' => 'required|int',
            'piloto_id' => 'required|int',
        ]);

        if($validate->fails()) {
            return response()->json(['error' => 'Hubo un error al almacenar el resultado.'], 500);
        }

        $input = $request->all();

        $resultado = new Resultado($input);
        $carrera = Carrera::findOrFail($input['carrera_id']);
        $piloto = Piloto::findOrFail($input['piloto_id']);
        $resultado->carrera()->associate($carrera);
        $resultado->piloto()->associate($piloto);
        $resultado->save();

        return response()->json(['success' => 'Resultado guardado con exito', 'resultado' => $resultado], 200);
    }

    public function update(Request $request, $carreraId, $pilotoId) {
        $resultado = Resultado::where('carrera_id', '=', $carreraId)->where('piloto_id', '=', $pilotoId);

        $resultado->update($request->all());

        return response()->json(['success' => 'Resultado editado con exito', 'resultado' => $resultado], 200);
    }

    public function delete($carreraId, $pilotoId) {
        $resultado = Resultado::where('carrera_id', '=', $carreraId)->where('piloto_id', '=', $pilotoId);
        $resultado->delete();
        return response()->json(['success' => 'Resultado borrado con exito', 'resultado' => $resultado], 200);
    }
}

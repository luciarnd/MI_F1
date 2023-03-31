<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{

    public function index() {
        return Role::all();
    }

    public function show($id) {
        $rol = Role::findOrFail($id);

        return response()->json(['rol' => $rol], 200);
    }
    public function store(Request $request) {
        $validate = Validator::make($request->all(), [
            'nombre' => 'required|string'
        ]);

        if($validate->fails()) {
            return response()->json(['error' => 'Hubo un error al almacenar el rol.'], 500);
        }

        $input = $request->all();

        $rol = new Role($input);
        $rol->save();
        return response()->json(['success' => 'Rol guardado con exito', 'rol' => $rol], 200);
    }

    public function update(Request $request, $id) {
        $rol = Role::findOrFail($id);

        $rol->update($request->all());
        return response()->json(['success' => 'Rol editado con exito', 'rol' => $rol], 200);
    }

    public function delete($id) {
        $rol = Role::findOrFail($id);

        $rol->delete();
        return response()->json(['success' => 'Rol borrado con exito', 'rol' => $rol], 200);
    }
}

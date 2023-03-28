<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index() {
        return User::all();
    }

    public function show($id) {
        $user = Auth::user();

        return response()->json(['user' => $user], 200);
    }

    public function store(Request $request) {
        $validate = Validator::make($request->all(), [
            'nombre' => 'required|string',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string'
        ]);

        if($validate->fails()) {
            return response()->json(['error' => 'Hubo un error al almacenar el usuario.'], 500);
        }

        $user = User::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 2
        ]);
        $user->save();
        return response()->json(['success' => 'Usuario guardado con exito', 'usuario' => $user], 200);
    }

    public function update(Request $request, $id) {
        $user = User::findOrFail($id);
        $userAuth = Auth::user();

        if($request->exists('role_id')) {
            if($userAuth->role_id == 1) {
                $user->update($request->all());
                return response()->json(['success' => 'Usuario editado con exito', 'usuario' => $user], 200);
            } else {
                return response()->json(['error' => 'No puedes editar el rol']);
            }
        } else {
            $user->update($request->all());
            return response()->json(['success' => 'Usuario editado con exito', 'usuario' => $user], 200);
        }
    }

    public function delete($id) {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['success' => 'Usuario borrado con exito', 'usuario' => $user], 200);
    }
}

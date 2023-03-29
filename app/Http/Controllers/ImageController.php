<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function update(Request $request, $id) {
        $image = Image::findOrFail($id);

        if($file = $request->file('image')) {
            $name = $file->getClientOriginalName();
            Storage::put('public/productos/' . $name, file_get_contents($file->getRealPath()));
            $image->nombre = $name;
            $image->save();
        }

        return response()->json(['success' => 'Imagen editada con exito', 'imagen' => $image], 200);
    }
    public function delete($id) {
        $imagen = Image::findOrFail($id);
        $imagen->delete();
        return response()->json(['success' => 'Imagen borrada con exito', 'imagen' => $imagen], 200);
    }
}

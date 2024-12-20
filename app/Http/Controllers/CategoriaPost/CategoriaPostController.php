<?php

namespace App\Http\Controllers\CategoriaPost;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoriaCollection;
use App\Http\Resources\CategoriaResource;
use App\Models\CategoriaPost;
use Illuminate\Http\Request;

class CategoriaPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new CategoriaCollection(CategoriaPost::all());
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required'
        ]);
        $categoria = CategoriaPost::create($request->all());

        return response()->json([
            'message' => 'Categoría creada exitosamente',
            'data' => $categoria
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $categoria = CategoriaPost::findOrFail($id);

        return new CategoriaResource($categoria);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $categoria = CategoriaPost::find($id);

        if(!$categoria) {
            return response()->json([
                'message' => 'Categoria no encontrada'
            ]. 404);
        }

        $request->validate([
            'nombre' => 'required'
        ]);

        if(isset($request['nombre'])) {
            $categoria->nombre = $request['nombre'];
        }

        $categoria->save();

        return response()->json([
            'message' => 'Categoria actualizada correctamente',
            'data' => $categoria
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $categoria = CategoriaPost::find($id);

        if(!$categoria) {
            return response()->json([
                'message' => 'Categoria no encontrada'
            ], 404);
        }

        $categoria->delete();

        return response()->json([
            'message' => 'Categoria eliminada correctamente'
        ]);
    }
}

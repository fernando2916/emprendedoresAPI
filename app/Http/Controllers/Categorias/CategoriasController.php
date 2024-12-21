<?php

namespace App\Http\Controllers\Categorias;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoriasResource;
use App\Models\Categorias;
use Illuminate\Http\Request;

class CategoriasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new CategoriasResource(Categorias::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'tipo' => 'required',
        ]);
        $categoria = Categorias::create($request->all());

        return response()->json([
            'message' => 'Categoría creada exitosamente',
            'data' => $categoria
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($tipo)
    {
       // Filtrar las categorías por tipo
    $categorias = Categorias::where('tipo', $tipo)->get();

    // Verificar si existen categorías con ese tipo
    if ($categorias->isEmpty()) {
        return response()->json(['message' => 'No se encontraron categorías para este tipo'], 404);
    }

    // Retornar las categorías utilizando un resource (opcional)
    return CategoriasResource::collection($categorias);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $categoria = Categorias::find($id);

        if(!$categoria) {
            return response()->json([
                'message' => 'Categoria no encontrada'
            ]. 404);
        }

        $request->validate([
            'nombre' => 'required',
            'tipo' => 'required',
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
        $categoria = Categorias::find($id);

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

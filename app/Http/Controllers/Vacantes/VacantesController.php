<?php

namespace App\Http\Controllers\Vacantes;

use App\Http\Controllers\Controller;
use App\Http\Resources\VacantesResource;
use App\Models\Vacantes;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class VacantesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return response()->json(['vacantes' => Vacantes::all()]);
        return new VacantesResource(Vacantes::all());
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'puesto' => 'required',
            'modalidad' => 'required',
            'horario' => 'required',
            'salario' => 'required',
            'postulacion' => 'required',
            'descripcion' => 'required',
            'requisitos' => 'required',
        ]);

        $validateData['identificador'] = Str::uuid();

        $vacante = Vacantes::create($validateData);

        return response()->json([
            'message' => 'Vacante creada correctamente',
            'data' => $vacante
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $vacante = Vacantes::where('id', $id)->first();
        if(!$vacante) {

            return response()->json([
            'message' => ' Vacante no encontrada'
            ],404);
        }
        return new VacantesResource($vacante);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

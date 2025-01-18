<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VacantesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);

        // return [
        //     'id' => $this->id,
        //     'puesto' => $this->puesto,
        //     'modalidad' => $this->modalidad,
        //     'horario' => $this->horario,
        //     'salario' => $this->salario,
        //     'identificador' => $this->identificador,
        //     'postulacion' => $this->postulacion,
        //     'descripcion' => $this->descripcion,
        //     'requisitos' => $this->requisitos
        // ];
            
    }
}

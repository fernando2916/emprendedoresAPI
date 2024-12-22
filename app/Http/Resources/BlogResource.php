<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'titulo' => $this->titulo,
            'imagen' => $this->imagen_url,
            'slug' => $this->slug,
            'descripción_corta' => $this->descripción_corta,
            'contenido' => $this->contenido,
            'post_id' => $this->post_id,
            'categorias' => $this->categorias_id,
            'tipo' => $this->tipo,
            'tiempo_de_lectura' => $this->tiempo_de_lectura,
            'user_id' => $this->user_id,
            'estado' => $this->estado,
            'created_at' => $this->created_at,
        ];
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacantes extends Model
{
    use HasFactory;

    // const MODALIDAD = ['Presencial', 'Hibrido', 'Home Office'];

    protected $fillable = [
        'id',
        'puesto',
        'modalidad',
        'horario',
        'salario',
        'postulacion',
        'identificador',
        'descripcion',
        'requisitos',
    ];

//     protected static function boot() {
//         parent::boot();

//         static::saving(function ($categorias) {
//            if(!in_array($categorias->modalidad, self::MODALIDAD)) {
//                throw new \Exception('Tipo de modalidad no válido');
//            }
//         });
//    }
}

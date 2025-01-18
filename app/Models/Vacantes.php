<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacantes extends Model
{
    use HasFactory;

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
}

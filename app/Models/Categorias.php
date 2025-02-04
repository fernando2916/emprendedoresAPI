<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categorias extends Model
{
    use HasFactory;

    const TIPOS = ['Post', 'Productos', 'Cursos', 'Recursos'];

    protected $fillable = ['nombre', 'tipo'];

    protected static function boot() {
         parent::boot();

         static::saving(function ($categorias) {
            if(!in_array($categorias->tipo, self::TIPOS)) {
                throw new \Exception('Tipo de categoria no válido');
            }
         });
    }

    public function posts() : HasMany
    {
        return $this->hasMany(Blog::class);
    }
}

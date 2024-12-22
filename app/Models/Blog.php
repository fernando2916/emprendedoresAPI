<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;


class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'imagen_url',
        'descripción_corta',
        'contenido',
        'categorias_id',
        'post_id',
        'slug',
        'tipo',
        'tiempo_de_lectura',
        'user_id',
        'estado',
    ];

    public function categoria() : BelongsTo {
        return $this->belongsTo(Categorias::class);
    }

    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }


    // protected $with = ['categoria'];

    // Generar slug del título
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public static function boot() {
        parent::boot();

        static::creating(function($blog) {
            $blog->slug = Str::slug($blog->titulo);
        });

        static::updating(function ($blog) {
            $blog->slug = Str::slug($blog->titulo);
        });
    }
}

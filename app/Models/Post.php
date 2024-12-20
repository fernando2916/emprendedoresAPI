<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;


class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'imagen_url',
        'descripción_corta',
        'contenido',
        'categoria_posts_id',
        'slug',
        'tipo',
        'tiempo_de_lectura',
        'user_id',
        'estado',
        
    ];

    public function categoria() : BelongsTo {
        return $this->belongsTo(CategoriaPost::class, 'categoria_posts_id');
    }

    public function user() : BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }

     // Generar slug del título
     public function getRouteKeyName()
     {
         return 'slug';
     }
 
     public static function boot() {
         parent::boot();
 
         static::creating(function($post) {
             $post->slug = Str::slug($post->titulo);
         });
 
         static::updating(function ($post) {
             $post->slug = Str::slug($post->titulo);
         });
     }
}

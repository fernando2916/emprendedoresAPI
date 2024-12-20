<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoriaPost extends Model
{
    use HasFactory;

    protected $fillable = ['nombre'];

    public function posts() : HasMany
    {
        return $this->hasMany(Post::class);
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('imagen_url');
            $table->string('descripción_corta');
            $table->text('contenido');
            $table->string('post_id')->unique()->nullable(true);
            $table->string('slug')->unique();
            $table->foreignId('categorias_id')->constrained()->onDelete('cascade');
            $table->string('tipo');
            $table->string('tiempo_de_lectura');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('estado', ['pendiente', 'publicado'])->default('pendiente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};

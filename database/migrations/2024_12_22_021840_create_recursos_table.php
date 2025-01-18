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
        Schema::create('recursos', function (Blueprint $table) {
            $table->id();            
            $table->string('Nombre');            
            $table->string('imagen_url');            
            $table->string('descripción');            
            $table->enum('tipo', ['Psd', 'Pdf', 'AI', 'Vector', 'Foto', 'Mockups']);            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recursos');
    }
};

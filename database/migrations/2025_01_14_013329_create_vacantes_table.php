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
        Schema::create('vacantes', function (Blueprint $table) {
            $table->id();
            $table->string('puesto');
            $table->string('modalidad');
            $table->string('horario');
            $table->string('salario');
            $table->string('identificador')->unique()->nullable(true);
            $table->string('postulacion');
            $table->text('descripcion');
            $table->text('requisitos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vacantes');
    }
};

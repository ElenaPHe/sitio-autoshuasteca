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
        Schema::create('mantenimientos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('imagen')->nullable();
            // Agregar las columnas que seran los paquetes que tendran el precio por ejemplo $2,250 que no pueda recibir ningun valor que no sea numero
            $table->integer('paqueteOne');
            $table->integer('paqueteTwo');
            $table->integer('paqueteThree');
            $table->integer('paqueteFour');
            $table->integer('paqueteFive');
            $table->integer('paqueteSix');
            $table->integer('paqueteSeven');
            $table->integer('paqueteEight');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mantenimientos');
    }
};

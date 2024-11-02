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
        Schema::create('nuevos', function (Blueprint $table) {
            $table->id();
            $table->string('modelo')->nullable();
            $table->string('fotoAuto')->nullable();
            $table->json('infoGeneral')->nullable();
            $table->json('disenio')->nullable();
            $table->json('disenioContenido')->nullable();
            $table->json('colores')->nullable();
            $table->json('tecnologia')->nullable();
            $table->json('tecnologiaContenido')->nullable();
            $table->json('galeria')->nullable();
            $table->json('versiones')->nullable();
            $table->boolean('estado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nuevos');
    }
};

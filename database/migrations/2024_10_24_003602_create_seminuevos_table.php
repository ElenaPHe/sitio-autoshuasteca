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
        Schema::create('seminuevos', function (Blueprint $table) {
            $table->id();
            $table->string('fotoAuto')->nullable(); // Imagen del auto, ya lo cambie a nullable, solo que aqui no aparece, deberia agregarlo?
            $table->json('infoGeneral')->nullable(); //Información general (array JSON), puede ser nulo
            $table->text('descripcion'); // Texto de la descripcion
            $table->json('infoDistribuidor')->nullable(); // informacion del distribuidor (array JSON), puede ser nulo
            $table->json('carrusel'); // Contendra varias imagenes del auto, sera un cast de array
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seminuevos');
    }
};

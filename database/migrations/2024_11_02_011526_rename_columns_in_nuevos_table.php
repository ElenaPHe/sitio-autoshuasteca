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
        Schema::table('nuevos', function (Blueprint $table) {

            $table->renameColumn('diseño', 'disenio');
            $table->renameColumn('diseñoContenido', 'disenioContenido');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nuevos', function (Blueprint $table) {
            $table->renameColumn('disenio', 'diseño');
            $table->renameColumn('disenioContenido', 'diseñoContenido');
        });
    }
};

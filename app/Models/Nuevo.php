<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nuevo extends Model
{
    use HasFactory;

    protected $fillable =[
        'modelo', // Modelo del auto
        'fotoAuto', // Imagen del auto
        'infoGeneral', // Contendra varia informacion, sera un cast de array
        'disenio', //Contendra varia informacion, sera un cast de array
        'disenioContenido', //Contendra varia informacion, sera un cast de array
        'colores', //Contendra varias imagenes del auto, sera un cast de array
        'tecnologia', //Contendra varia informacion, sera un cast de array
        'tecnologiaContenido', //Contendra varia informacion, sera un cast de array
        'galeria', //Contendra varias imagenes del auto, sera un cast de array
        'versiones', //Contendra sera un cast de array
        'estado', //  Estado del auto
    ];

    protected $casts = [
        'infoGeneral' => 'array', // Cast de array
        'disenio' => 'array', // Cast de array
        'disenioContenido' => 'array', // Cast de array
        'colores' => 'array', // Cast de array
        'tecnologia' => 'array', // Cast de array
        'tecnologiaContenido' => 'array', // Cast de array
        'galeria' => 'array',  // Cast de array
        'versiones' => 'array',  // Cast de array
        'estado' => 'boolean', // Cast de boolean
    ];
}

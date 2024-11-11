<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refacciones extends Model
{
    use HasFactory;

    protected $fillable =[
        'imagen', // Imagen de la refaccion, sera String
        'nombre',  // Nombre de la refaccion, sera String
        'infoGeneral', // Contendra varia informacion, sera un cast de array
        'tipoRefaccion', // Tipo de refaccion, sera String
        'infoKit', // Contendra varia informacion, sera un cast de array
        'carruselKit', // Contendra varias imagenes del kit, sera un cast de array
        'aplicacion', // Contendra mucho texto, sera un Text
        'estado', //  Estado de la refaccion, sera un boolean

    ];

    protected $casts = [
        'infoGeneral' => 'array', // Cast de array
        'infoKit' => 'array', // Cast de array
        'carruselKit' => 'array', // Cast de array
        'estado' => 'boolean', // Cast de boolean

    ];
}

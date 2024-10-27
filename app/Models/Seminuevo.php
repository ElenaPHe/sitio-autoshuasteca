<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seminuevo extends Model
{
    use HasFactory;

    protected $fillable =[
        'fotoAuto', // Imagen del auto
        'infoGeneral', // Contendra varia informacion, sera un cast de array
        'descripcion', // Texto de la descripcion
        'infoDistribuidor', // Contendra varia informacion, sera un cast de array
        'carrusel', // Contendra varias imagenes del auto, sera un cast de array
    ];

    protected $casts = [
        'infoGeneral' => 'array', // Cast de array
        'infoDistribuidor' => 'array', // Cast de array
        'carrusel' => 'array',  // Cast de array
    ];

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inicio extends Model
{
    use HasFactory;

    protected $fillable = [
        'imagen',
        'carrusel',
        'promociones',
        'terminos',
    ];

    protected $casts = [
        'carrusel' => 'array',
        'promociones' => 'array'
    ];
}

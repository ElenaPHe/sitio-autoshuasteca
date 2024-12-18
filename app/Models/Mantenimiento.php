<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mantenimiento extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'imagen',
        'paqueteOne',
        'paqueteTwo',
        'paqueteThree',
        'paqueteFour',
        'paqueteFive',
        'paqueteSix',
        'paqueteSeven',
        'paqueteEight',
    ];
}

<?php

use App\Http\Controllers\InicioController;
use App\Http\Controllers\MantenimientoController;
use App\Http\Controllers\NuevosController;
use App\Http\Controllers\SeminuevosController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RefaccionesController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

// Route::get('/', function () {
//     return Inertia::render('Welcome');
// })->name('welcome');

Route::get('/', [InicioController::class, 'seccionwelcomeindex'])->name('welcome');

Route::get('/Mantenimiento', [MantenimientoController::class, 'seccionmantenimientoindex'])->name('mantenimiento');
Route::get('/Seminuevos', [SeminuevosController::class, 'seccionseminuevosindex'])->name('seminuevos');
Route::get('/AutosNuevos', [NuevosController::class, 'seccionnuevosindex'])->name('autosnuevos');
Route::get('/Refacciones', [RefaccionesController::class, 'seccioneRefaccionesIndex'])->name('refacciones');

Route::get('/Seminuevos/{id}/{marca}/{modelo}/{year}', [SeminuevosController::class, 'showSeminuevo'])->name('seminuevos.show');
Route::get('/AutosNuevos/{id}/{modelo}', [NuevosController::class, 'showNuevo'])->name('autosnuevos.show');
Route::get('/Refacciones/{id}/{nombre}', [RefaccionesController::class, 'showRefaccion'])->name('refacciones.show');

// Route::get('/Modelos/', function () {
//     return Inertia::render('Secciones/AutosNuevos');
// })->name('autosnuevos');

// Route::get('/Seminuevos/', function () {
//     return Inertia::render('Secciones/Seminuevos');
// })->name('seminuevos');

Route::get('/Garantia/', function () {
    return Inertia::render('Secciones/Garantia');
})->name('garantia');

// Route::get('/Refacciones/', function () {
//     return Inertia::render('Secciones/Refacciones');
// })->name('refacciones');

// Route::get('/Mantenimiento/', function () {
//     return Inertia::render('Secciones/Mantenimiento');
// })->name('mantenimiento');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {

    // Route::get('/SeccionBienvenida/', function () {
    //     return Inertia::render('Admin/Nuevos/Index');
    // })->name('admin-nuevos');

    Route::get('/seccionbienvenida', [InicioController::class, 'index'])->name('inicio.index');

    //inicio subir y eliminar imagen
    Route::post('/inicio/{id}/subirImagen', [InicioController::class, 'subirImagen'])->name('inicio.subirImagen');
    Route::delete('/inicio/{id}/eliminarImagen', [InicioController::class, 'eliminarImagen'])->name('inicio.eliminarImagen');

    Route::post('/inicio/{id}/subirCarrusel', [InicioController::class, 'subirCarrusel'])->name('inicio.subirCarrusel');
    Route::delete('/inicio/{id}/eliminarCarrusel', [InicioController::class, 'eliminarCarrusel'])->name('inicio.eliminarCarrusel');


    Route::post('/inicio/{id}/subirImagenPromo/{index}', [InicioController::class, 'subirImagenPromo'])->name('inicio.subirImagenPromo');
    Route::delete('/seccionbienvenida/eliminarImagenPromo/{id}/{index}', [InicioController::class, 'eliminarImagenPromo'])->name('inicio.eliminarImagenPromo');

    Route::get('/seccionbienvenida/create', [InicioController::class, 'create'])->name('inicio.create');
    Route::post('/seccionbienvenida', [InicioController::class, 'store'])->name('inicio.store');
    Route::get('/seccionbienvenida/{id}/edit', [InicioController::class, 'edit'])->name('inicio.edit');
    Route::put('/seccionbienvenida/{id}', [InicioController::class, 'actualizar'])->name('inicio.actualizar');

    // Route::get('/seccionbienvenida/{id}/editImage', [InicioController::class, 'editImage'])->name('inicio.editImage');
    // Route::put('/seccionbienvenida/{id}', [InicioController::class, 'updateImagenPrincipal'])->name('inicio.actualizarImagenPrincipal');

    // Seccion Nuevos
    Route::get('/seccion-nuevos', [NuevosController::class, 'index'])->name('nuevos.index');
    Route::get('/seccion-nuevos/create', [NuevosController::class, 'create'])->name('nuevos.create');
    Route::get('/seccion-nuevos/{id}/edit', [NuevosController::class, 'edit'])->name('nuevos.edit');
    Route::post('/seccion-nuevos', [NuevosController::class, 'store'])->name('nuevos.store');

    Route::put('/seccion-nuevos/{id}', [NuevosController::class, 'actualizaInfoNuevo'])->name('nuevos.update');
    Route::post('/seccion-nuevos/{id}/cambiarEstado', [NuevosController::class, 'cambiarEstado'])->name('nuevos.cambiarEstado');
    Route::delete('/seccion-nuevos/{id}', [NuevosController::class, 'eliminarAuto'])->name('nuevos.destroy');


    //Seccion Nuevos cambio de imagenes
    //foto auto
    Route::post('seccion-nuevos/{id}/subirImagen', [NuevosController::class, 'subirFotoAuto'])->name('nuevos.cambiarFotoAuto');
    Route::delete('seccion-nuevos/{id}/eliminarImagen', [NuevosController::class, 'eliminarFotoAuto'])->name('nuevos.eliminarFotoAuto');

    //galeria
    Route::post('seccion-nuevos/{id}/subirGaleria', [NuevosController::class, 'subirImagenGaleria'])->name('nuevos.cambiarImagenGaleria');
    Route::delete('seccion-nuevos/{id}/galeria/{index}', [NuevosController::class, 'eliminarImagenGaleria'])->name('nuevos.eliminarImagenGaleria');

    //Colores cambio de imagenes
    Route::post('seccion-nuevos/{id}/subirColor', [NuevosController::class, 'subirImagenColor'])->name('nuevos.cambiarImagenColor');
    Route::delete('seccion-nuevos/eliminarColor/{id}/{index}', [NuevosController::class, 'eliminarImagenColor'])->name('nuevos.eliminarImagenColor');

    //Galeria Diseño contenido
    Route::post('seccion-nuevos/{id}/subirDiseno/{index}', [NuevosController::class, 'subirImagenDisenio'])->name('nuevos.cambiarImagenDesingContent');
    Route::delete('seccion-nuevos/eliminarDiseno/{id}/{index}', [NuevosController::class, 'eliminarImagenDesingContent'])->name('nuevos.eliminarImagenDesingContent');

    //Galeria Tecnologia
    Route::post('seccion-nuevos/{id}/subirTecnologia/{index}', [NuevosController::class, 'subirImagenTecnologia'])->name('nuevos.cambiarImagenTecnologiaContenido');
    Route::delete('seccion-nuevos/eliminarTecnologia/{id}/{index}', [NuevosController::class, 'eliminarImagenTecnologia'])->name('nuevos.eliminarImagenTecnologiaContenido');

    //Imagen versiones
    Route::post('seccion-nuevos/{id}/subirVersiones/{index}', [NuevosController::class, 'subirImagenVersiones'])->name('nuevos.cambiarImagenVersiones');
    Route::delete('seccion-nuevos/eliminarVersiones/{id}/{index}', [NuevosController::class, 'eliminarImagenVersiones'])->name('nuevos.eliminarImagenVersiones');


    // Seccion Seminuevos
    Route::get('/seccion-seminuevos', [SeminuevosController::class, 'index'])->name('seminuevos.index');
    Route::get('/seccion-seminuevos/create', [SeminuevosController::class, 'create'])->name('seminuevos.create');
    Route::post('/seccion-seminuevos', [SeminuevosController::class, 'store'])->name('seminuevos.store');
    Route::get('/seccion-seminuevos/{id}/edit', [SeminuevosController::class, 'edit'])->name('seminuevos.edit');
    Route::put('/seccion-seminuevos/{id}', [SeminuevosController::class, 'update'])->name('seminuevos.update');
    Route::delete('/seccion-seminuevos/{id}', [SeminuevosController::class, 'destroy'])->name('seminuevos.destroy');


    //Seminuevos Imagen Update y Delete
    Route::post('seccion-seminuevos/{id}/subirImagen', [SeminuevosController::class, 'subirImagen'])->name('seminuevos.subirImagen');
    Route::delete('seccion-seminuevos/{id}/eliminarImagen', [SeminuevosController::class, 'eliminarImagen'])->name('seminuevos.eliminarImagen');

    //Seminuevo Carrusel Update y Delete
    Route::post('seccion-seminuevos/{id}/subirCarrusel', [SeminuevosController::class, 'subirCarrusel'])->name('seminuevos.subirCarrusel');
    Route::delete('seccion-seminuevos/{id}/eliminarCarrusel', [SeminuevosController::class, 'eliminarCarrusel'])->name('seminuevos.eliminarCarrusel');


    // Seccion Mantenimiento
    Route::get('/seccion-mantenimiento', [MantenimientoController::class, 'index'])->name('mantenimiento.index');
    Route::get('/seccion-mantenimiento/create', [MantenimientoController::class, 'create'])->name('mantenimiento.create');
    Route::post('/seccion-mantenimiento', [MantenimientoController::class, 'store'])->name('mantenimiento.store');
    Route::get('/seccion-mantenimiento/{id}/edit', [MantenimientoController::class, 'edit'])->name('mantenimiento.edit');
    Route::put('/seccion-mantenimiento/{id}', [MantenimientoController::class, 'actualizar'])->name('mantenimiento.actualizar');
    Route::delete('/seccion-mantenimiento/{id}', [MantenimientoController::class, 'destroy'])->name('mantenimiento.destroy');
    Route::post('/seccion-mantenimiento/{id}/subirImagen', [MantenimientoController::class, 'subirImagen'])->name('mantenimiento.subirImagen');
    Route::delete('/seccion-mantenimiento/{id}/eliminarImagen', [MantenimientoController::class, 'eliminarImagen'])->name('mantenimiento.eliminarImagen');


    //Seccion Refacciones
    Route::get('/seccion-refacciones', [RefaccionesController::class, 'index'])->name('refacciones.index');
    Route::get('/seccion-refacciones/create', [RefaccionesController::class, 'create'])->name('refacciones.create');
    Route::post('/seccion-refacciones', [RefaccionesController::class, 'store'])->name('refacciones.store');
    Route::get('/seccion-refacciones/{id}/edit', [RefaccionesController::class, 'edit'])->name('refacciones.edit');

    Route::put('/seccion-refacciones/{id}', [RefaccionesController::class, 'update'])->name('refacciones.update');
    Route::delete('/seccion-refacciones/{id}', [RefaccionesController::class, 'eliminarRefaccion'])->name('refacciones.destroy');

    //Refacciones Imagen Update y Delete
    Route::post('seccion-refacciones/{id}/subirImagen', [RefaccionesController::class, 'subirImagen'])->name('refacciones.subirImagen');
    Route::delete('seccion-refacciones/{id}/eliminarImagen', [RefaccionesController::class, 'eliminarImagen'])->name('refacciones.eliminarImagen');

    //Refacciones Carrusel Update y Delete
    Route::post('seccion-refacciones/{id}/subirCarrusel', [RefaccionesController::class, 'subirImagenCarrusel'])->name('refacciones.subirCarrusel');
    Route::delete('seccion-refacciones/eliminarCarrusel/{id}/{index}', [RefaccionesController::class, 'eliminarImagenCarrusel'])->name('refacciones.eliminarCarrusel');








    // Route::get('/BienvenidaCreate/', function () {
    //     return Inertia::render('Admin/Nuevos/Create');
    // })->name('admin-nuevos-create');

    // Route::get('/BienvenidaEdit/', function () {
    //     return Inertia::render('Admin/Nuevos/Edit');
    // })->name('admin-nuevos-edit');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

<?php

use App\Http\Controllers\InicioController;
use App\Http\Controllers\MantenimientoController;
use App\Http\Controllers\ProfileController;
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

Route::get('/Modelos/', function () {
    return Inertia::render('Secciones/AutosNuevos');
})->name('autosnuevos');

Route::get('/Seminuevos/', function () {
    return Inertia::render('Secciones/Seminuevos');
})->name('seminuevos');

Route::get('/Garantia/', function () {
    return Inertia::render('Secciones/Garantia');
})->name('garantia');

Route::get('/Refacciones/', function () {
    return Inertia::render('Secciones/Refacciones');
})->name('refacciones');

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
    Route::get('/seccionbienvenida/create', [InicioController::class, 'create'])->name('inicio.create');
    Route::post('/seccionbienvenida', [InicioController::class, 'store'])->name('inicio.store');
    Route::get('/seccionbienvenida/{id}/edit', [InicioController::class, 'edit'])->name('inicio.edit');
    Route::put('/seccionbienvenida/{id}', [InicioController::class, 'actualizar'])->name('inicio.actualizar');

    // Route::get('/seccionbienvenida/{id}/editImage', [InicioController::class, 'editImage'])->name('inicio.editImage');
    // Route::put('/seccionbienvenida/{id}', [InicioController::class, 'updateImagenPrincipal'])->name('inicio.actualizarImagenPrincipal');

    // Seccion Mantenimiento
    Route::get('/seccion-mantenimiento', [MantenimientoController::class, 'index'])->name('mantenimiento.index');
    Route::get('/seccion-mantenimiento/create', [MantenimientoController::class, 'create'])->name('mantenimiento.create');
    Route::post('/seccion-mantenimiento', [MantenimientoController::class, 'store'])->name('mantenimiento.store');
    Route::get('/seccion-mantenimiento/{id}/edit', [MantenimientoController::class, 'edit'])->name('mantenimiento.edit');
    Route::put('/seccion-mantenimiento/{id}', [MantenimientoController::class, 'actualizar'])->name('mantenimiento.actualizar');
    Route::delete('/seccion-mantenimiento/{id}', [MantenimientoController::class, 'destroy'])->name('mantenimiento.destroy');




    // Route::get('/BienvenidaCreate/', function () {
    //     return Inertia::render('Admin/Nuevos/Create');
    // })->name('admin-nuevos-create');

    Route::get('/BienvenidaEdit/', function () {
        return Inertia::render('Admin/Nuevos/Edit');
    })->name('admin-nuevos-edit');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

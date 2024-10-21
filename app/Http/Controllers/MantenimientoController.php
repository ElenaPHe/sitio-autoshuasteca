<?php

namespace App\Http\Controllers;

use App\Models\Mantenimiento;
use Inertia\Inertia;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MantenimientoController extends Controller
{
    public function index()
    {
        $mantenimientos = Mantenimiento::all();
        return Inertia::render('Admin/Mantenimiento/Index', [
            'mantenimientos' => $mantenimientos
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Mantenimiento/Create');
    }

    public function store()
    {
        $mantenimiento = new Mantenimiento();
        $mantenimiento->titulo = request('titulo');


        $mantenimiento->imagen = request('imagen')->store('mantenimientos', 'public');


        $mantenimiento->paqueteOne = request('paqueteOne');
        $mantenimiento->paqueteTwo = request('paqueteTwo');
        $mantenimiento->paqueteThree = request('paqueteThree');
        $mantenimiento->paqueteFour = request('paqueteFour');
        $mantenimiento->paqueteFive = request('paqueteFive');
        $mantenimiento->paqueteSix = request('paqueteSix');
        $mantenimiento->paqueteSeven = request('paqueteSeven');
        $mantenimiento->paqueteEight = request('paqueteEight');
        $mantenimiento->save();
        return redirect()->route('mantenimiento.index');
    }

    public function edit($id)
    {
        $mantenimiento = Mantenimiento::find($id);
        return Inertia::render('Admin/Mantenimiento/Edit', [
            'mantenimiento' => $mantenimiento
        ]);
    }

    public function actualizar($id)
    {
        $mantenimiento = Mantenimiento::find($id);

        if (request()->hasFile('imagen')) {
            // Eliminar la imagen anterior del almacenamiento
            Storage::disk('public')->delete($mantenimiento->imagen);
            // Guardar la nueva imagen en el almacenamiento
            $mantenimiento->imagen = request('imagen')->store('mantenimientos', 'public');
        }

        // Rellenar el registro de mantenimiento con todos los datos de la solicitud
        $mantenimiento->fill(request()->all());

        // Guardar el registro de mantenimiento
        $mantenimiento->saveOrFail();

        // $mantenimiento->titulo = request('titulo');
        // if (request()->hasFile('imagen')) {
        //     Storage::disk('public')->delete($mantenimiento->imagen);
        //     $mantenimiento->imagen = request('imagen')->store('mantenimientos', 'public');
        // }else
        // {
        //     $mantenimiento->imagen = $mantenimiento->imagen;
        // }
        // $mantenimiento->paqueteOne = request('paqueteOne');
        // $mantenimiento->paqueteTwo = request('paqueteTwo');
        // $mantenimiento->paqueteThree = request('paqueteThree');
        // $mantenimiento->paqueteFour = request('paqueteFour');
        // $mantenimiento->paqueteFive = request('paqueteFive');
        // $mantenimiento->paqueteSix = request('paqueteSix');
        // $mantenimiento->paqueteSeven = request('paqueteSeven');
        // $mantenimiento->paqueteEight = request('paqueteEight');

        // $mantenimiento->save();

        return redirect()->route('mantenimiento.index');
    }

    public function destroy($id)
    {
        $mantenimiento = Mantenimiento::find($id);
        Storage::disk('public')->delete($mantenimiento->imagen);
        $mantenimiento->delete();
        return redirect()->route('mantenimiento.index');
    }
}

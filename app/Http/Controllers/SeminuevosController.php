<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

use App\Models\Seminuevo;

class SeminuevosController extends Controller
{
    public function index()
    {

        $seminuevos = Seminuevo::all();

        return Inertia::render('Admin/Seminuevos/Index', [
            'seminuevos' => $seminuevos
        ]);
    }

    public function seccionseminuevosindex()
    {
        $seminuevos = Seminuevo::all();
        return Inertia::render('Secciones/Seminuevos', [
            'seminuevos' => $seminuevos
        ]);
    }

    public function create()
    {

        return Inertia::render('Admin/Seminuevos/Create');
    }

    public function store(Request $request)
    {
        // Validar los campos
        $request->validate([
            'fotoAuto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'infoGeneral' => 'required|array',
            'descripcion' => 'required|string',
            'infoDistribuidor' => 'nullable|array',
            'carrusel.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $seminuevo = new Seminuevo();

        $modelo = $request->input('infoGeneral.modelo');

        $folderName = "autosSeminuevos/{$modelo}";

        // $folderName .= $modelo;


        // Si se sube una imagen, guardarla en la carpeta publica
        if ($request->hasFile('fotoAuto')) {
            // Crear $image para guardar la imagen
            $image = $request->file('fotoAuto');
            // Generar nombre único para la carpeta de cada auto seminuevo
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $fotoAutoPath = $image->storeAs("{$folderName}/fotoAuto", $imageName, 'public');
            $seminuevo->fotoAuto = $fotoAutoPath;
        }

        // Guardar las imágenes del carrusel
        $carruselPaths = [];
        if ($request->hasFile('carrusel')) {
            foreach ($request->file('carrusel') as $carruselImage) {
                // Generar nombre único para cada imagen del carrusel
                $imageName = time() . '_' . $carruselImage->getClientOriginalName();
                $carruselPaths[] = $carruselImage->storeAs("{$folderName}/carrusel", $imageName, 'public');
            }
            $seminuevo->carrusel = $carruselPaths;
        }

        // Guardar los cambios en la base de datos
        $seminuevo->infoGeneral = $request->input('infoGeneral');
        $seminuevo->descripcion = $request->input('descripcion');
        $seminuevo->infoDistribuidor = $request->input('infoDistribuidor');
        $seminuevo->save();

        // Redirigir con un mensaje de éxito
        return redirect()->route('seminuevos.index')->with('success', 'Auto seminuevo agregado correctamente');
    }

    public function edit($id)
    {
        $seminuevo = Seminuevo::findOrFail($id);

        return Inertia::render('Admin/Seminuevos/Edit', [
            'seminuevo' => $seminuevo
        ]);
    }

    public function showSeminuevo($id)
    {
        $seminuevo = Seminuevo::findOrFail($id);



        return Inertia::render('Secciones/ShowSeminuevo', [
            'seminuevo' => $seminuevo
        ]);
    }

    public function update(Request $request, $id)
    {
        // Validar los campos
        $request->validate([
            'infoGeneral' => 'required|array',
            'descripcion' => 'required|string',
            'infoDistribuidor' => 'nullable|array',
            'carrusel.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Encontrar el registro existente
        $seminuevo = Seminuevo::findOrFail($id);

        $folderName = "autosSeminuevos/";

        // Crear un identificador único para la carpeta de cada auto seminuevo
        // $folderName = uniqid('autoSeminuevo_', true);

        // Guardar la imagen principal (fotoAuto)
        // if ($request->hasFile('fotoAuto')) {
        //     // Eliminar la imagen antigua
        //     if ($seminuevo->fotoAuto) {
        //         Storage::disk('public')->delete($seminuevo->fotoAuto);
        //     }
        //     // Guardar la nueva imagen
        //     $image = $request->file('fotoAuto');
        //     $imageName = time() . '.' . $image->getClientOriginalExtension();
        //     $fotoAutoPath = $image->storeAs("{$folderName}/fotoAuto", $imageName, 'public');
        //     $seminuevo->fotoAuto = $fotoAutoPath;
        // }

        // Guardar las imágenes del carrusel
        // $carruselPaths = [];
        // if ($request->hasFile('carrusel')) {
        //     // Eliminar las imágenes antiguas del carrusel
        //     foreach ($seminuevo->carrusel as $oldCarruselImage) {
        //         Storage::disk('public')->delete($oldCarruselImage);
        //     }
        //     // Guardar las nuevas imágenes
        //     foreach ($request->file('carrusel') as $carruselImage) {
        //         $imageName = time() . '_' . $carruselImage->getClientOriginalExtension();
        //         $carruselPaths[] = $carruselImage->storeAs("{$folderName}/carrusel", $imageName, 'public');
        //     }
        //     $seminuevo->carrusel = $carruselPaths;
        // }

        // Actualizar los demás campos
        $seminuevo->infoGeneral = $request->input('infoGeneral');
        $seminuevo->descripcion = $request->input('descripcion');
        $seminuevo->infoDistribuidor = $request->input('infoDistribuidor');

        // Guardar los cambios en la base de datos
        $seminuevo->save();

        // Redirigir con un mensaje de éxito
        return redirect()->route('seminuevos.index')->with('success', 'Auto seminuevo actualizado correctamente');
    }


    public function subirImagen(Request $request, $id)
    {

        $seminuevo = Seminuevo::findOrFail($id);

        $request->validate([
            'fotoAuto' => 'required|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        //Eliminar la imagen antigua
        if ($seminuevo->fotoAuto) {
            Storage::delete('public/' . $seminuevo->fotoAuto);
        }

        //Aqui se guarda la nueva imagen
        $image = $request->file('fotoAuto');
        $imageName = time() . '.' . $image->getClientOriginalExtension();

        $fotoAutoPath = $request->File('fotoAuto')->storeAs('autosSeminuevos/fotoAuto', $imageName, 'public');

        $seminuevo->update([
            'fotoAuto' => $fotoAutoPath
        ]);

        return back()->with('success', 'Imagen actualizada correctamente');
    }

    public function subirCarrusel(Request $request, $id)
    {
        $seminuevo = Seminuevo::findOrFail($id);

        $request->validate([
            'carrusel.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Eliminar las imágenes antiguas del carrusel
        if ($seminuevo->carrusel) {
            foreach ($seminuevo->carrusel as $oldCarruselImage) {
                Storage::disk('public')->delete($oldCarruselImage);
            }
        }

        // Guardar las nuevas imágenes del carrusel
        $carruselPaths = [];
        foreach ($request->file('carrusel') as $carruselImage) {
            $imageName = time() . '_' . $carruselImage->getClientOriginalName();
            $carruselPaths[] = $carruselImage->storeAs('autosSeminuevos/carrusel', $imageName, 'public');
        }

        $seminuevo->update([
            'carrusel' => $carruselPaths
        ]);

        return back()->with('success', 'Carrusel actualizado correctamente');
    }



    public function eliminarImagen($id)
    {
        $seminuevo = Seminuevo::findOrFail($id);

        if ($seminuevo->fotoAuto) {

            $storagePath = $seminuevo->fotoAuto;

            if (Storage::disk('public')->exists($storagePath)) {
                Storage::disk('public')->delete($storagePath);

                $seminuevo->update([
                    'fotoAuto' => null
                ]);
            }
            return back()->with('success', 'Imagen eliminada correctamente');
        }
        return back()->with('error', 'No se pudo eliminar la imagen');
    }

    public function eliminarCarrusel($id)
    {
        $seminuevo = Seminuevo::findOrFail($id);

        if ($seminuevo->carrusel) {
            foreach ($seminuevo->carrusel as $carruselImage) {
                if (Storage::disk('public')->exists($carruselImage)) {
                    Storage::disk('public')->delete($carruselImage);
                }
            }

            $seminuevo->update([
                'carrusel' => []
            ]);

            return back()->with('success', 'Carrusel eliminado correctamente');
        }
        return back()->with('error', 'No se pudo eliminar el carrusel');
    }
}

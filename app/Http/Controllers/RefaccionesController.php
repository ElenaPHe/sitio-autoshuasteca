<?php

namespace App\Http\Controllers;

use App\Models\Refacciones;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;


class RefaccionesController extends Controller
{
    public function index()
    {

        $refacciones = Refacciones::all();
        return Inertia::render(
            'Admin/Refacciones/Index',
            ['refacciones' => $refacciones]
        );
    }

    public function seccioneRefaccionesIndex()
    {
        $refacciones = Refacciones::all();
        return Inertia::render('Secciones/Refacciones', ['refacciones' => $refacciones]);
    }

    public function showRefaccion($id)
    {
        $refaccion = Refacciones::findOrFail($id);



        return Inertia::render('Secciones/ShowRefacciones', [
            'refaccion' => $refaccion
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Refacciones/Create');
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'imagen' => 'required|mimes:png,jpg,jpeg,svg|max:5120',
            'nombre' => 'required|string',
            'infoGeneral' => 'nullable|array',
            'tipoRefaccion' => 'required|string',
            'infoKit' => 'nullable|array',
            'carruselKit.*' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:5120',
            'aplicacion' => 'nullable|string'
        ]);

        $validatedData['estado'] = false;

        $folderName = 'refacciones/' .  $validatedData['nombre'] ."/";

        if ($request->hasFile('imagen')) {
            $image = $request->file('imagen');
            $imageName = time() . '.' . $image->getClientOriginalName();
            $imagePath = $image->storeAs("{$folderName}/imagen", $imageName, 'public');
            $validatedData['imagen'] = $imagePath;
        }

        if ($request->hasFile('carruselKit')) {
            $carruselPath = [];
            foreach ($request->file('carruselKit') as $carrusel) {
                $carruselName = time() . '.' . $carrusel->getClientOriginalName();
                $carruselPath[] = $carrusel->storeAs("{$folderName}/carrusel", $carruselName, 'public');
            }
            $validatedData['carruselKit'] = $carruselPath;
        }

        $refacciones = new Refacciones($validatedData);

        $refacciones->save();

        return redirect()->route('refacciones.index');
    }

    public function edit($id)
    {
        $refacciones = Refacciones::findOrFail($id);
        return Inertia::render('Admin/Refacciones/Edit', ['refacciones' => $refacciones]);
    }

    public function update(Request $request, $id)
    {
        $refacciones = Refacciones::findOrFail($id);

        if ($refacciones) {
            $validatedData = $request->validate([
                // 'imagen' => 'nullable|mimes:png,jpg,jpeg,svg|max:5120',
                // 'nombre' => 'required|string',
                'infoGeneral' => 'nullable|array',
                'tipoRefaccion' => 'required|string',
                'infoKit' => 'nullable|array',
                // 'carruselKit.*' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:5120',
                'aplicacion' => 'nullable|string'
            ]);

            $refacciones->update($validatedData);

            return redirect()->route('refacciones.index');
        } else {
            return redirect()->route('refacciones.index');
        }
    }

    public function subirImagen(Request $request, $id)
    {
        $refacciones = Refacciones::findOrFail($id);

        if ($refacciones) {
            $validatedData = $request->validate([
                'imagen' => 'required|mimes:png,jpg,jpeg,svg|max:5120'
            ]);
            $folderName = 'refacciones/' . $refacciones->nombre;
            if ($request->hasFile('imagen')) {
                $image = $request->file('imagen');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs("{$folderName}/imagen", $imageName, 'public');
            }
            $refacciones->update([
                'imagen' => $imagePath]);
            return back()->with('success', 'Imagen subida correctamente');
        } else {
            return back()->with('error', 'No se encontro la imagen');
        }
    }
    public function eliminarImagen($id)
    {
        $refacciones = Refacciones::findOrFail($id);

        if ($refacciones->imagen) {
            $storePath = $refacciones->imagen;

            if (Storage::disk('public')->exists($storePath)) {
                Storage::disk('public')->delete($storePath);
                $refacciones->update(['imagen' => null]);
                return back()->with('success', 'Imagen eliminada correctamente');
            }
        }
        return back()->with('error', 'No se encontro la imagen');
    }
    public function subirImagenCarrusel(Request $request, $id)
    {
        $refacciones = Refacciones::findOrFail($id);

        // dd($request->all());

        $request->validate([
            'carruselKit.*' => 'required|image|mimes:png,jpg,jpeg,svg|max:5120'
        ]);

        $folderName = 'refacciones/' . $refacciones->nombre . '/carrusel';
        $imagenCarrusel = $refacciones->carruselKit ?? [];

        foreach ($request->file('carruselKit') as $carrusel) {
            $carruselName = time() . '.' . $carrusel->getClientOriginalName();
            $imagenCarrusel[] = $carrusel->storeAs("{$folderName}/", $carruselName, 'public');
        }
        $refacciones->update(['carruselKit' => $imagenCarrusel]);
        return back()->with('success', 'Imagen subida correctamente');
    }
    public function eliminarImagenCarrusel($id, $index)
    {
        $refacciones = Refacciones::findOrFail($id);
        $carruselKit = $refacciones->carruselKit;

        if(isset($carruselKit[$index])){
            $imagenCarrusel = $carruselKit[$index];
            $storePath = $imagenCarrusel;

        if (Storage::disk('public')->exists($storePath)) {
            Storage::disk('public')->delete($storePath);
        }

        unset($carruselKit[$index]);
        $refacciones->carruselKit = array_values($carruselKit);
        $refacciones->save();

        return back()->with('success', 'Imagen eliminada correctamente');
        }
        return back()->with('error', 'No se encontro la imagen');
    }

    public function eliminarRefaccion($id){
        $refaccion = Refacciones::findOrFail($id);

        $rutaCarpeta = 'refacciones/' . $refaccion->nombre;

        if (Storage::disk('public')->exists($rutaCarpeta)) {
            Storage::disk('public')->deleteDirectory($rutaCarpeta);
        }

        $refaccion->delete();
        return redirect()->route('refacciones.index');
    }
}

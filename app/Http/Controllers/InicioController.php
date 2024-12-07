<?php

namespace App\Http\Controllers;

use App\Models\Inicio;
use Inertia\Inertia;
use Illuminate\Http\RedirectResponse;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SebastianBergmann\CodeUnit\FunctionUnit;

class InicioController extends Controller
{
    public function index()
    {
        $inicios = Inicio::all();
        return Inertia::render('Admin/Inicio/Index', [
            'inicios' => $inicios
        ]);
    }

    //redirigir la información de la base de datos a la vista Welcome
    public function seccionwelcomeindex()
    {
        $inicios = Inicio::all();
        return Inertia::render('Welcome', [
            'inicios' => $inicios
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Inicio/Create');
    }

    public function store(Request $request): RedirectResponse //Guardar los datos que se mandan del fomulario Inicio/Edit.vue
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            'carrusel' => 'required|array',
            'carrusel.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            'promociones' => 'required|array',
            'promociones.*.titulo' => 'required|string|max:255',
            'promociones.*.descripcion' => 'required|string|max:500',
            'promociones.*.imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            'promociones.*.terminos' => 'required|string',
            'terminos' => 'required|string',
        ]);

        $inicio = new Inicio();

        // Guardar la imagen principal en Inicio/imagen
        $imagePath = $inicio->imagen;

        if ($request->hasFile('imagen')) {
            $imagePath = $validated['imagen']->store('Inicio/imagen', 'public');
        }

        // Guardar las imágenes del carrusel en Inicio/carrusel
        $carruselImages = [];
        if (isset($validated['carrusel'])) { // Verificar si se han enviado imágenes del carrusel
            foreach ($validated['carrusel'] as $file) { // Iterar sobre cada imagen del carrusel
                $carruselImages[] = $file->store('Inicio/carrusel', 'public'); // Guardar la imagen en el disco
            }
        }

        // Guardar las promociones con sus imágenes en Inicio/promociones
        $promocionesData = [];
        if (isset($validated['promociones'])) { // Verificar si se han enviado promociones
            foreach ($validated['promociones'] as $index => $promocion) { // Iterar sobre cada promoción
                $promocionImage = null; // Inicializar la variable de la imagen de la promoción
                if (isset($promocion['imagen'])) { // Verificar si se ha enviado una imagen para la promoción
                    $promocionImage = $promocion['imagen']->store('Inicio/promociones', 'public'); // Guardar la imagen en el disco
                }

                $promocionesData[] = [  // Guardar los datos de la promoción
                    'titulo' => $promocion['titulo'], // Guardar el título de la promoción
                    'imagen' => $promocionImage, // Guardar la imagen de la promoción
                    'descripcion' => $promocion['descripcion'], // Guardar la descripción de la promoción
                ];
            }
        }

        $inicio->imagen = $imagePath; // Guardar la imagen principal
        $inicio->carrusel = $carruselImages; // Guardar las imágenes del carrusel
        $inicio->promociones = $promocionesData; // Guardar las promociones

        $inicio->save();

        return redirect()->route('inicio.index')->with('success', 'Formulario guardado exitosamente');
    }

    public function edit($id)
    {
        // Obtener el registro de Inicio a editar
        $inicio = Inicio::findOrFail($id);

        // Retornar la vista con los datos existentes
        return Inertia::render('Admin/Inicio/Edit', [
            'inicio' => $inicio,
        ]);
    }


    public function actualizar(Request $request, $id)
    {

        $inicio = Inicio::findOrFail($id);

        // $inicio->imagen = $request->imagen;
        // $inicio->carrusel = $request->carrusel;
        $inicio->promociones = $request->promociones;
        $inicio->terminos = $request->terminos;

        $inicio->save();


        return redirect()->route('inicio.index');
    }


    public function subirImagen(Request $request,$id)
    {
        $inicio = Inicio::findOrFail($id);
        $request->validate([
            'imagen' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if($inicio->imagen){
            Storage::delete('public/'.$inicio->imagen);
        }

        $image = $request->file('imagen');
        $imageName = time().'.'.$image->getClientOriginalExtension();

        $imagePath = $request->File('imagen')->storeAs('Inicio/imagen',$imageName,'public');

        $inicio->update([
            'imagen' => $imagePath
        ]);
        return back()->with('success','Imagen actualizada correctamente');
    }
    public function eliminarImagen($id)
    {
        $inicio = Inicio::findOrFail($id);
        if($inicio->imagen){
            $storagePath = $inicio->imagen;
            if(Storage::disk('public')->exists($storagePath)){
                Storage::disk('public')->delete($storagePath);

                $inicio->update([
                    'imagen' => ''
                ]);
            }
            return back()->with('success','Imagen eliminada correctamente');
        }
        return back()->with('success','No se pudo eliminar la imagen');
    }

    public function subirCarrusel(Request $request,$id)
    {
        $inicio = Inicio::findOrFail($id);
        $request->validate([
            'carrusel.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($inicio->carrusel) {
            foreach ($inicio->carrusel as $oldCarruselImage) {
                Storage::disk('public')->delete($oldCarruselImage);
            }
        }

        $carruselPaths = [];
        foreach ($request->file('carrusel') as $carruselImage) {
            $imageName = time() . '_' . $carruselImage->getClientOriginalName();
            $carruselPaths[] = $carruselImage->storeAs('Inicio/carrusel', $imageName, 'public');
        }

        $inicio->update([
            'carrusel' => $carruselPaths
        ]);
    }
    public function eliminarCarrusel(Request $request, $id)
    {
        $inicio = Inicio::findOrFail($id);

        if ($inicio->carrusel){
            foreach($inicio->carrusel as $carruselImage){
                if(Storage::disk('public')->exists($carruselImage)){
                    Storage::disk('public')->delete($carruselImage);
                }
            }
            $inicio->update([
                'carrusel' => []
            ]);
            return back()->with('success', 'Carrusel eliminado correctamente');
        }
        return back()->with('error', 'No se pudo eliminar el carrusel');
    }

    public function subirImagenPromo(Request $request, $id, $index)
    {
        // Obtener el registro de Inicio a editar
        $inicio = Inicio::findOrFail($id);

        // Puedes mostrar el index y el request para depurar
        // dd($index, $request->all());

        // / Validar la imagen
        $request->validate([
            'promociones.*.imagen' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        // Verificar que el archivo de imagen exista en la solicitud
        if (!$request->hasFile("promociones.$index.imagen")) {
            return redirect()->route('inicio.edit', $id)->withErrors('La imagen de la promoción no se encontró.');
        }

        $image = $request->file("promociones.$index.imagen");
        $imageName = time() . '.' . $image->getClientOriginalExtension();

        $promoImagePath = $image->storeAs('Inicio/promociones', $imageName, 'public');

        // Actualizar la imagen en la promoción
        $promociones = $inicio->promociones;
        $promociones[$index]['imagen'] = $promoImagePath;

        $inicio->promociones = $promociones;
        $inicio->save();

        return redirect()->route('inicio.edit', $id)->with('success', 'Imagen de la promoción actualizada correctamente');
    }

    public function eliminarImagenPromo($id, $index)
    {
        // Obtener el registro de Inicio a editar
        $inicio = Inicio::findOrFail($id);

        // Verificar si la imagen existe en el índice de la promoción
        if (isset($inicio->promociones[$index]['imagen']) && $inicio->promociones[$index]['imagen']) {
            $storagePath = $inicio->promociones[$index]['imagen'];

            // Eliminar la imagen de la promoción
            if (Storage::disk('public')->exists($storagePath)) {
                Storage::disk('public')->delete($storagePath);

                // Trabajar directamente con el array de promociones
                $promociones = $inicio->promociones;
                $promociones[$index]['imagen'] = '';

                // Actualizar el campo promociones y guardar el registro
                $inicio->promociones = $promociones;
                $inicio->save();
            }

            return redirect()->route('inicio.edit', $id)->with('success', 'Imagen de la promoción eliminada correctamente');
        }

        return redirect()->route('inicio.edit', $id)->with('success', 'Imagen de la promoción no se pudo eliminar');
    }
}

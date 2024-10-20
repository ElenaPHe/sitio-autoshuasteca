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


    public function actualizar(Request $request, $id){

        $inicio = Inicio::findOrFail($id);

        $inicio->imagen = $request->imagen;
        $inicio->carrusel = $request->carrusel;
        $inicio->promociones = $request->promociones;

        $inicio->save();


        return redirect()->route('inicio.index');
    }

    // public function editImage($id)
    // {
    //     // Obtener el registro de Inicio a editar
    //     $inicio = Inicio::findOrFail($id);

    //     // Retornar la vista con los datos existentes
    //     return Inertia::render('Admin/Inicio/EditImage', [
    //         'inicio' => $inicio,
    //     ]);
    // }

    // public function updateImagenPrincipal(Request $request, $id)
    // {
    //     // Obtener el registro de Inicio a editar
    //     $inicio = Inicio::findOrFail($id);

    //     // Validar los datos del formulario
    //     $validated = $request->validate([
    //         'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
    //     ]);

    //     // Eliminar la imagen anterior si existe
    //     if ($inicio->imagen) {
    //         Storage::disk('public')->delete($inicio->imagen);
    //     }

    //     $imagePath = $inicio->imagen;
    //     if ($request->hasFile('imagen')) {
    //         $imagePath = $validated['imagen']->store('Inicio/imagen', 'public');
    //     }

    //     // Actualizar la imagen principal solo si se ha proporcionado una nueva
    //     $inicio->imagen = $imagePath;

    //     // Guardar los cambios en la tabla Inicio para solo actualizar la imagen principal
    //     $inicio->save();

    //     return redirect()->route('inicio.index')->with('success', 'Imagen principal actualizada correctamente');
    // }



    // public function actualizar(Request $request, $id){

    //     $inicio = Inicio::findOrFail($id);

    //     $inicio->imagen = $request->imagen;
    //     $inicio->carrusel = $request->carrusel;
    //     $inicio->promociones = $request->promociones;

    //     $inicio->save();


    //     //Redirigir a la vista de inicio
    //     return redirect()->route('inicio.index');

    // }

    // public function actualizar(Request $request, $id)
    // {
    //     $inicio = Inicio::findOrFail($id);

    //     // Verificar y eliminar la imagen anterior si hay una nueva
    //     if ($request->hasFile('imagen')) {
    //         // Eliminar la imagen anterior si existe
    //         if ($inicio->imagen) {
    //             Storage::disk('public')->delete($inicio->imagen);
    //         }
    //         // Almacenar la nueva imagen
    //         $inicio->imagen = $request->file('imagen')->store('Inicio/imagen', 'public');
    //     }

    //     // Verificar y manejar el carrusel (similar a imagen)
    //     if ($request->hasFile('carrusel')) {
    //         // Puedes implementar una lógica similar para manejar el carrusel,
    //         // dependiendo de cómo estés almacenando las imágenes del carrusel
    //         foreach ($inicio->carrusel as $imagenCarrusel) {
    //             Storage::disk('public')->delete($imagenCarrusel);
    //         }
    //         // Almacenar las nuevas imágenes del carrusel
    //         $inicio->carrusel = [];
    //         foreach ($request->file('carrusel') as $image) {
    //             $inicio->carrusel[] = $image->store('Inicio/carrusel', 'public');
    //         }
    //     }

    //     // Actualizar promociones, asegurándote de que no se pase a null
    //     $promociones = [];
    //     if ($request->promociones && is_array($request->promociones)) {
    //         foreach ($request->promociones as $promo) {
    //             $promocion = [
    //                 'titulo' => $promo['titulo'],
    //                 'descripcion' => $promo['descripcion'],
    //                 // Asegúrate de que sea un archivo antes de llamar a store()
    //                 'imagen' => isset($promo['imagen']) && $promo['imagen'] instanceof \Illuminate\Http\UploadedFile
    //                     ? $promo['imagen']->store('Inicio/promociones', 'public')
    //                     : null,
    //             ];

    //             // Lógica para eliminar imagen anterior
    //             if (isset($promo['imagenAnterior'])) {
    //                 Storage::disk('public')->delete($promo['imagenAnterior']);
    //             }

    //             $promociones[] = $promocion;
    //         }
    //     }
    //     $inicio->promociones = $promociones;

    //     $inicio->save();

    //     // Redirigir a la vista de inicio
    //     return redirect()->route('inicio.index');
    // }


    // public function actualizar(Request $request, $id)
    // {
    //     $inicio = Inicio::findOrFail($id);

    //     // Validación de los campos
    //     $validated = $request->validate([
    //         'imagen' => 'nullable|image|max:2048',
    //         'carrusel.*' => 'nullable|image|max:2048',
    //         'promociones' => 'array',
    //         'promociones.*.titulo' => 'required|string|max:255',
    //         'promociones.*.descripcion' => 'required|string|max:255',
    //         'promociones.*.imagen' => 'nullable|image|max:2048',
    //     ]);

    //     // Manejar la imagen principal (si se sube una nueva)
    //     if ($request->hasFile('imagen')) {
    //         // Eliminar la imagen anterior si existe
    //         if ($inicio->imagen) {
    //             Storage::delete($inicio->imagen);
    //         }
    //         // Guardar la nueva imagen
    //         $path = $request->file('imagen')->store('Inicio/imagen');
    //         $inicio->imagen = $path;
    //     }

    //     // Manejar las imágenes del carrusel (si se suben nuevas)
    //     if ($request->hasFile('carrusel')) {
    //         // Eliminar imágenes anteriores del carrusel
    //         if ($inicio->carrusel) {
    //             foreach (json_decode($inicio->carrusel, true) as $carruselImg) {
    //                 Storage::delete($carruselImg);
    //             }
    //         }
    //         // Guardar las nuevas imágenes del carrusel
    //         $carruselPaths = [];
    //         foreach ($request->file('carrusel') as $file) {
    //             $path = $file->store('Inicio/carrusel');
    //             $carruselPaths[] = $path;
    //         }
    //         $inicio->carrusel = json_encode($carruselPaths); // Guardar como JSON
    //     }

    //     // Verificar si se han enviado promociones, si no, inicializar como un array vacío
    //     $promocionesInput = $request->input('promociones', []); // Si no existen, retorna un array vacío

    //     // Obtener promociones actuales, si ya es un array lo usamos directamente, sino lo decodificamos
    //     $existingPromociones = is_array($inicio->promociones)
    //         ? $inicio->promociones
    //         : json_decode($inicio->promociones, true) ?? [];

    //     // Manejar las promociones (solo actualizar campos modificados)
    //     $promociones = [];
    //     foreach ($promocionesInput as $index => $promo) {
    //         $promoData = [
    //             'titulo' => $promo['titulo'],
    //             'descripcion' => $promo['descripcion'],
    //         ];

    //         // Si hay una imagen nueva para la promoción, la guardamos, si no, mantenemos la imagen existente
    //         if ($request->hasFile("promociones.$index.imagen")) {
    //             $promoImagePath = $request->file("promociones.$index.imagen")->store('Inicio/promociones');
    //             $promoData['imagen'] = $promoImagePath;
    //         } else {
    //             // Si no se subió una nueva imagen, usamos la imagen existente
    //             $promoData['imagen'] = $existingPromociones[$index]['imagen'] ?? null;
    //         }

    //         $promociones[] = $promoData;
    //     }

    //     // Guardar las promociones actualizadas en formato JSON
    //     $inicio->promociones = json_encode($promociones);

    //     // Guardar los cambios en la base de datos
    //     $inicio->save();

    //     // Redirigir con un mensaje de éxito
    //     return redirect()->route('inicio.index')->with('success', 'Sección de bienvenida actualizada correctamente.');
    // }
}

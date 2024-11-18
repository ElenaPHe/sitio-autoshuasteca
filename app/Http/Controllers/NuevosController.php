<?php

namespace App\Http\Controllers;

use App\Models\Nuevo;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NuevosController extends Controller
{
    public function index()
    {
        $nuevos = Nuevo::all();
        return Inertia::render('Admin/Nuevos/Index', [
            'nuevos' => $nuevos
        ]);
    }
    public function seccionnuevosindex()
    {
        $nuevos = Nuevo::all();
        return Inertia::render('Secciones/AutosNuevos', [
            'nuevos' => $nuevos
        ]);
    }
    public function showNuevo($id)
    {
        $nuevos = Nuevo::findOrFail($id);
        return Inertia::render('Secciones/ShowNuevos', [
            'nuevo' => $nuevos
        ]);
    }



    public function create()
    {
        return Inertia::render('Admin/Nuevos/Create');
    }

    public function store(Request $request)
    {

        // Interceptar la petición con dd
        // dd($request->all());


        $validatedData = $request->validate([
            'modelo' => 'required|string',
            'fotoAuto' => 'required|mimes:png,jpg,jpeg,svg|max:5120',
            'infoGeneral' => 'nullable|array',
            'disenio' => 'nullable|array',
            'disenioContenido' => 'nullable|array',
            'disenioContenido.*.titulo' => 'nullable|string',
            'disenioContenido.*.subtitulo' => 'nullable|string',
            'disenioContenido.*.descripcion' => 'nullable|string',
            'disenioContenido.*.imagen' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:5120',
            'colores.*' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:5120',
            'tecnologia' => 'nullable|array',
            'tecnologiaContenido' => 'nullable|array',
            'tecnologiaContenido.*.titulo' => 'nullable|string',
            'tecnologiaContenido.*.subtitulo' => 'nullable|string',
            'tecnologiaContenido.*.descripcion' => 'nullable|string',
            'tecnologiaContenido.*.imagen' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:5120',
            'galeria.*' => 'nullable|image|mimes:png,jpg,jpeg,svg,webp|max:5120',
            'versiones' => 'nullable|array'

        ]);

        $validatedData['estado'] = false;


        $folderName = "autosNuevos/" . $validatedData['modelo'] . "/";

        // Guardar la imagen de foto auto

        if ($request->hasFile('fotoAuto')) {
            $image = $request->file('fotoAuto');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $fotoAutoPath = $image->storeAs("{$folderName}/fotoAuto", $imageName, 'public');
            $validatedData['fotoAuto'] = $fotoAutoPath;
        }

        // Guardar imagen de designContent
        $desingContentData = [];
        if (isset($validatedData['disenioContenido'])) {
            foreach ($validatedData['disenioContenido'] as $design) {

                $designImagePath = null;
                if (isset($design['imagen'])) {
                    $designImage = $design['imagen'];
                    $designImageName = time() . '_' . $designImage->getClientOriginalName();
                    $designImagePath = $designImage->storeAs("{$folderName}/ContenidoDisenio", $designImageName, 'public');
                }

                $desingContentData[] = [
                    'titulo' => $design['titulo'],
                    'subtitulo' => $design['subtitulo'],
                    'descripcion' => $design['descripcion'],
                    'imagen' => $designImagePath
                ];
            }
        }
        $validatedData['disenioContenido'] = $desingContentData;

        $tecnologiaContenidoData = [];
        if (isset($validatedData['tecnologiaContenido'])) {
            foreach ($validatedData['tecnologiaContenido'] as $tecnologia) {
                $tecnologiaImagePath = null;
                if (isset($tecnologia['imagen'])) {
                    $tecnologiaImage = $tecnologia['imagen'];
                    $tecnologiaImageName = time() . '_' . $tecnologiaImage->getClientOriginalName();
                    $tecnologiaImagePath = $tecnologiaImage->storeAs("{$folderName}/tecnologiaContenido", $tecnologiaImageName, 'public');
                }

                $tecnologiaContenidoData[] = [
                    'titulo' => $tecnologia['titulo'],
                    'subtitulo' => $tecnologia['subtitulo'],
                    'descripcion' => $tecnologia['descripcion'],
                    'imagen' => $tecnologiaImagePath
                ];
            }
        }
        $validatedData['tecnologiaContenido'] = $tecnologiaContenidoData;

        $versionesData = [];
        if (isset($validatedData['versiones'])) {
            foreach ($validatedData['versiones'] as $version) {
                $infoGenData = [];
                if (isset($version['infoGen'])) {
                    foreach ($version['infoGen'] as $infoGen) {
                        $infoGenData[] = [
                            'precioVersion' => $infoGen['precioVersion'],
                            'rendimiento' => $infoGen['rendimiento'],
                            'potencia' => $infoGen['potencia']
                        ];
                    }
                }

                $caracteristicasData = [];
                if (isset($version['caracteristicas'])) {
                    foreach ($version['caracteristicas'] as $caracteristica) {
                        $caracteristicasData[] = $caracteristica;
                    }
                }

                $versionImagePath = null;
                if (isset($version['imagen'])) {
                    $versionImage = $version['imagen'];
                    $versionImageName = time() . '_' . $versionImage->getClientOriginalName();
                    $versionImagePath = $versionImage->storeAs("{$folderName}/versiones", $versionImageName, 'public');
                }

                $versionesData[] = [
                    'nomVersion' => $version['nomVersion'],
                    'imagen' => $versionImagePath,
                    'infoGen' => $infoGenData,
                    'caracteristicas' => $caracteristicasData
                ];
            }
        }
        $validatedData['versiones'] = $versionesData;

        // Guardar las imagenes de colores
        if ($request->hasFile('colores')) {
            $coloresPaths = [];
            foreach ($request->file('colores') as $colorImage) {
                $colorImageName = time() . '_' . $colorImage->getClientOriginalName();
                $colorImagePath = $colorImage->storeAs("{$folderName}/colores", $colorImageName, 'public');
                $coloresPaths[] = $colorImagePath;
            }
            $validatedData['colores'] = $coloresPaths;
        }

        // Guardar las imagenes de galeria
        if ($request->hasFile('galeria')) {
            $galeriaPaths = [];
            foreach ($request->file('galeria') as $galeriaImage) {
                $galeriaImageName = time() . '_' . $galeriaImage->getClientOriginalName();
                $galeriaImagePath = $galeriaImage->storeAs("{$folderName}/galeria", $galeriaImageName, 'public');
                $galeriaPaths[] = $galeriaImagePath;
            }
            $validatedData['galeria'] = $galeriaPaths;
        }

        // Crear el nuevo auto
        $nuevo = new Nuevo($validatedData);

        $nuevo->save();

        return redirect()->route('nuevos.index');
    }

    public function edit($id)
    {
        $nuevo = Nuevo::findOrFail($id);
        return Inertia::render('Admin/Nuevos/Edit', [
            'nuevo' => $nuevo
        ]);
    }

    public function actualizaInfoNuevo(Request $request, $id)
    {
        $nuevo = Nuevo::findOrFail($id);

        if ($nuevo) {
            $validatedData = $request->validate([
                'modelo' => 'nullable|string',
                // 'fotoAuto' => 'required|mimes:png,jpg,jpeg,svg|max:5120',
                'infoGeneral' => 'nullable|array',
                'disenio' => 'nullable|array',
                'disenioContenido' => 'nullable|array',
                // 'disenioContenido.*.titulo' => 'nullable|string',
                // 'disenioContenido.*.subtitulo' => 'nullable|string',
                // 'disenioContenido.*.descripcion' => 'nullable|string',
                // 'disenioContenido.*.imagen' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:5120',
                // 'colores.*' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:5120',
                'tecnologia' => 'nullable|array',
                'tecnologiaContenido' => 'nullable|array',
                // 'galeria.*' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:5120',
                'versiones' => 'nullable|array'
            ]);

            $nuevo->update($validatedData);

            return redirect()->route('nuevos.index');
        } else {
            return redirect()->route('nuevos.index');
        }
    }

    public function cambiarEstado($id)
    {
        $nuevo = Nuevo::findOrFail($id);

        if ($nuevo) {
            $nuevo->estado = !$nuevo->estado;
            $nuevo->save();
            return redirect()->back();
        } else {
            return redirect()->route('nuevos.index');
        }
    }

    public function subirFotoAuto(Request $request, $id)
    {
        $nuevo = Nuevo::findOrFail($id);
        if ($nuevo) {
            $validatedData = $request->validate([
                'fotoAuto' => 'required|mimes:png,jpg,jpeg,svg|max:5120',
            ]);
            $folderName = "autosNuevos/" . $nuevo->modelo . "/";
            if ($request->hasFile('fotoAuto')) {
                $image = $request->file('fotoAuto');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $fotoAutoPath = $image->storeAs("{$folderName}/fotoAuto", $imageName, 'public');
                // $nuevo->fotoAuto = $fotoAutoPath;
                // $nuevo->save();
            }
            $nuevo->update([
                'fotoAuto' => $fotoAutoPath
            ]);
            return back()->with('success', 'Imagen subida correctamente');
        } else {
            return back()->with('error', 'No se pudo subir la imagen');
        }
    }

    public function eliminarFotoAuto($id)
    {
        $nuevo = Nuevo::findOrFail($id);

        if ($nuevo->fotoAuto) {

            $storagePath = $nuevo->fotoAuto;

            if (Storage::disk('public')->exists($storagePath)) {
                Storage::disk('public')->delete($storagePath);

                $nuevo->update([
                    'fotoAuto' => null
                ]);
            }
            return back()->with('success', 'Imagen eliminada correctamente');
        }
        return back()->with('error', 'No se pudo eliminar la imagen');
    }

    public function subirImagenGaleria(Request $request, $id)
    {
        $nuevo = Nuevo::findOrFail($id);


        $request->validate([
            'galeria.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $folderName = "autosNuevos/" . $nuevo->modelo . "/galeria";

        $galeriaNuevo = $nuevo->galeria ?? [];

        foreach ($request->file('galeria') as $galeriaImage) {
            $imageName = time() . '_' . $galeriaImage->getClientOriginalName();
            $galeriaNuevo[] = $galeriaImage->storeAs("{$folderName}/", $imageName, 'public');
        }

        $nuevo->update([
            'galeria' => $galeriaNuevo,
        ]);

        return back()->with('success', 'Imagen de la galeria subida correctamente');
    }

    public function eliminarImagenGaleria($id, $index)
    {
        $nuevo = Nuevo::findOrFail($id);
        $galeria = $nuevo->galeria;

        if (isset($galeria[$index])) {

            $imagenGaleria = $galeria[$index];

            $storagePath = $imagenGaleria;

            if (Storage::disk('public')->exists($storagePath)) {
                Storage::disk('public')->delete($storagePath);
            }

            unset($galeria[$index]);
            $nuevo->galeria = array_values($galeria);
            $nuevo->save();

            return back()->with('success', 'Imagen de la galeria eliminada correctamente');
        }
        return back()->with('error', 'No se pudo eliminar la imagen de la galeria');
    }

    public function subirImagenColor(Request $request, $id)
    {
        $nuevo = Nuevo::findOrFail($id);

        // dd($request->all());

        $request->validate([
            'colores.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $folderName = "autosNuevos/" . $nuevo->modelo . "/colores";

        $coloresNuevo = $nuevo->colores ?? [];

        foreach ($request->file('colores') as $colorImage) {
            $imageName = time() . '_' . $colorImage->getClientOriginalName();
            $coloresNuevo[] = $colorImage->storeAs("{$folderName}/", $imageName, 'public');
        }
        $nuevo->update([
            'colores' => $coloresNuevo,
        ]);
        return back()->with('success', 'Imagen de color subida correctamente');
    }
    public function eliminarImagenColor($id, $index)
    {
        $nuevo = Nuevo::findOrFail($id);
        $colores = $nuevo->colores;

        if (isset($colores[$index])) {

            $imagenColor = $colores[$index];

            $storagePath = $imagenColor;

            if (Storage::disk('public')->exists($storagePath)) {
                Storage::disk('public')->delete($storagePath);
            }

            unset($colores[$index]);
            $nuevo->colores = array_values($colores);
            $nuevo->save();

            return back()->with('success', 'Imagen de color eliminada correctamente');
        }
        return back()->with('error', 'No se pudo eliminar la imagen de color');
    }

    public function subirImagenDisenio(Request $request, $id, $index)
    {
        $nuevo = Nuevo::findOrFail($id);

        //dd
        // dd($request->all());

        $request->validate([
            'disenioContenido.*.imagen' => 'nullable|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $folderName = "autosNuevos/" . $nuevo->modelo . "/ContenidoDisenio";

        if (!$request->hasFile("disenioContenido.$index.imagen")) {
            return redirect()->route('nuevos.edit', $id)->with('error', 'No se pudo subir la imagen');
        }

        $image = $request->file("disenioContenido.$index.imagen");

        $imageName = time() . '_' . $image->getClientOriginalName();
        $disenioContenidoPath = $image->storeAs("{$folderName}/", $imageName, 'public');

        $disenioContenido = $nuevo->disenioContenido;
        $disenioContenido[$index]['imagen'] = $disenioContenidoPath;

        $nuevo->disenioContenido = $disenioContenido;
        $nuevo->save();

        return back()->with('success', 'Imagen subida correctamente');
    }

    public function eliminarImagenDesingContent($id, $index)
    {
        $nuevo = Nuevo::findOrFail($id);


        if (isset($nuevo->disenioContenido[$index]['imagen']) && $nuevo->disenioContenido[$index]['imagen']) {

            $storagePath = $nuevo->disenioContenido[$index]['imagen'];

            if (Storage::disk('public')->exists($storagePath)) {
                Storage::disk('public')->delete($storagePath);

                $disenioContenido = $nuevo->disenioContenido;
                $disenioContenido[$index]['imagen'] = '';

                $nuevo->disenioContenido = $disenioContenido;
                $nuevo->save();
            }
            return back()->with('success', 'Imagen eliminada correctamente');
        }
        return back()->with('error', 'No se pudo eliminar la imagen');
    }

    public function subirImagenTecnologia(Request $request, $id, $index)
    {
        $nuevo = Nuevo::findOrFail($id);

        $request->validate([
            'tecnologiaContenido.*.imagen' => 'nullable|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $folderName = "autosNuevos/" . $nuevo->modelo . "/tecnologiaContenido";

        if (!$request->hasFile("tecnologiaContenido.$index.imagen")) {
            return redirect()->route('nuevos.edit', $id)->with('error', 'No se pudo subir la imagen');
        }

        $image = $request->file("tecnologiaContenido.$index.imagen");

        $imageName = time() . '_' . $image->getClientOriginalName();
        $tecnologiaContenidoPath = $image->storeAs("{$folderName}/", $imageName, 'public');

        $tecnologiaContenido = $nuevo->tecnologiaContenido;
        $tecnologiaContenido[$index]['imagen'] = $tecnologiaContenidoPath;

        $nuevo->tecnologiaContenido = $tecnologiaContenido;
        $nuevo->save();

        return back()->with('success', 'Imagen subida correctamente');
    }

    public function eliminarImagenTecnologia($id, $index)
    {
        $nuevo = Nuevo::findOrFail($id);

        if (isset($nuevo->tecnologiaContenido[$index]['imagen']) && $nuevo->tecnologiaContenido[$index]['imagen']) {

            $storagePath = $nuevo->tecnologiaContenido[$index]['imagen'];

            if (Storage::disk('public')->exists($storagePath)) {
                Storage::disk('public')->delete($storagePath);

                $tecnologiaContenido = $nuevo->tecnologiaContenido;
                $tecnologiaContenido[$index]['imagen'] = '';

                $nuevo->tecnologiaContenido = $tecnologiaContenido;
                $nuevo->save();
            }
            return back()->with('success', 'Imagen eliminada correctamente');
        }
        return back()->with('error', 'No se pudo eliminar la imagen');
    }

    public function subirImagenVersiones(Request $request, $id, $index)
    {
        $nuevo = Nuevo::findOrFail($id);
        // dd($request->all());

        $request->validate([
            'versiones.*.imagen' => 'nullable|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $folderName = "autosNuevos/" . $nuevo->modelo . "/versiones";

        if (!$request->hasFile("versiones.$index.imagen")) {
            return redirect()->route('nuevos.edit', $id)->with('error', 'No se pudo subir la imagen');
        }

        $image = $request->file("versiones.$index.imagen");

        $imageName = time() . '_' . $image->getClientOriginalName();
        $versionesPath = $image->storeAs("{$folderName}/", $imageName, 'public');

        $versiones = $nuevo->versiones;
        $versiones[$index]['imagen'] = $versionesPath;

        $nuevo->versiones = $versiones;
        $nuevo->save();

        return back()->with('success', 'Imagen subida correctamente');
    }

    public function eliminarImagenVersiones($id, $index)
    {
        $nuevo = Nuevo::findOrFail($id);

        if (isset($nuevo->versiones[$index]['imagen']) && $nuevo->versiones[$index]['imagen']) {

            $storagePath = $nuevo->versiones[$index]['imagen'];

            if (Storage::disk('public')->exists($storagePath)) {
                Storage::disk('public')->delete($storagePath);

                $versiones = $nuevo->versiones;
                $versiones[$index]['imagen'] = '';

                $nuevo->versiones = $versiones;
                $nuevo->save();
            }
            return back()->with('success', 'Imagen eliminada correctamente');
        }
        return back()->with('error', 'No se pudo eliminar la imagen');
    }
}

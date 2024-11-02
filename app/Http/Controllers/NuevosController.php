<?php

namespace App\Http\Controllers;

use App\Models\Nuevo;
use Inertia\Inertia;
use Illuminate\Http\Request;

class NuevosController extends Controller
{
    public function index()
    {
        $nuevos = Nuevo::all();
        return Inertia::render('Admin/Nuevos/Index', [
            'nuevos' => $nuevos
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Nuevos/Create');
    }

    public function store(Request $request)
    {

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
            'galeria.*' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:5120',
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
                if (isset($design['image'])) {
                    $designImage = $design['image'];
                    $designImageName = time() . '_' . $designImage->getClientOriginalName();
                    $designImagePath = $designImage->storeAs("{$folderName}/ContenidoDiseño", $designImageName, 'public');
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
                if (isset($tecnologia['image'])) {
                    $tecnologiaImage = $tecnologia['image'];
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
                'disenioContenido.*.titulo' => 'nullable|string',
                'disenioContenido.*.subtitulo' => 'nullable|string',
                'disenioContenido.*.descripcion' => 'nullable|string',
                'disenioContenido.*.imagen' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:5120',
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
}

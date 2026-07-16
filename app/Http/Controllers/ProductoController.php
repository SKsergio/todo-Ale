<?php

namespace App\Http\Controllers;

use App\Models\Productos;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductoController extends Controller
{

    public function __construct(
        protected ImageUploadService $imageService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = min(max($request->integer('per_page', 10), 1), 100);

        $productos = Productos::oldest()
            ->paginate($perPage)
            ->withQueryString();

        return Inertia::render("main/productos/Index", [
            'categoriasProductos' => $productos
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación
        $validated = $request->validate([
            'nombre' => 'required|string|max:50',
            'descripcion' => 'nullable|string|max:155',
            'precio_estimado' => 'required|numeric',
            'categoria_producto_id' => 'required|integer',
            'imagenes' => 'nullable|array|max:5', // Máximo 5 fotos de una vez
            'imagenes.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048', // Max 2MB por foto
        ]);

        try {
            $producto = Productos::create($validated);

            if ($request->hasFile('imagenes')) {
                foreach ($request->file('imagenes') as $index => $file) {

                    $rutaImagen = $this->imageService->uploadImage($file, "productos/{$producto->id}");

                    $producto->imagenes()->create([
                        'image_url' => $rutaImagen,
                        // Si es la primera imagen del array (índice 0), la marcamos como principal
                        'es_principal' => $index === 0 ? true : false,
                    ]);
                }
            }
        } catch (\Exception $e) {
            return back()->withErrors([
                'error_general' => 'Ocurrió un error interno: ' . $e->getMessage()
            ]);
        }

        return redirect()->route('productos.index')->with('message', 'Producto creado con éxito');
    }

    /**
     * Display the specified resource.
     */
    public function show(Productos $productos)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Productos $producto)
    {
        // Validación (Te recomiendo mantener nombre y precio requeridos)
        $validated = $request->validate([
            'nombre' => 'required|string|max:50',
            'descripcion' => 'nullable|string|max:155',
            'precio_estimado' => 'required|numeric',
            'estado' => 'required|string',
            'categoria_producto_id' => 'required|integer',
            'imagenes' => 'nullable|array|max:5',
            'imagenes.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        try {
            $producto->update($validated);

            // 2. Procesar imágenes nuevas
            if ($request->hasFile('imagenes')) {

                // Verificamos si este producto ya tiene una foto principal guardada de antes
                $tienePrincipal = $producto->imagenes()->where('es_principal', true)->exists();

                foreach ($request->file('imagenes') as $index => $file) {

                    $rutaImagen = $this->imageService->uploadImage($file, "productos/{$producto->id}");

                    $producto->imagenes()->create([
                        'image_url' => $rutaImagen,
                        'es_principal' => (!$tienePrincipal && $index === 0) ? true : false,
                    ]);
                }
            }
        } catch (\Exception $e) {
            return back()->withErrors([
                'error_general' => 'Ocurrió un error interno: ' . $e->getMessage()
            ]);
        }

        return redirect()->route('productos.index')->with('message', 'Producto actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Productos $productos)
    {
        //
    }
}

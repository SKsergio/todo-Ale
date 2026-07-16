<?php

namespace App\Http\Controllers;

use App\Models\CategoriaProductos;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoriaProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = min(max($request->integer('per_page', 10), 1), 100);

        $categoriaProductos = CategoriaProductos::oldest()
            ->paginate($perPage)
            ->withQueryString();

        return Inertia::render("catalogue/category-products/Index", [
            'categoriasProductos' => $categoriaProductos
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:50',
            'descripcion' => 'nullable|string|max:155',
        ]);

        try {
            CategoriaProductos::create($validated);
        } catch (\Exception $e) {
            return back()->withErrors([
                'error_general' => 'Ocurrió un error interno: ' . $e->getMessage()
            ]);
        }

        return back()->with('message', 'Categoría creada con éxito');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CategoriaProductos $categoriaProductos)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:50',
            'descripcion' => 'nullable|string|max:155',
        ]);

        try {
            $categoriaProductos->update($validated);
        } catch (\Exception $e) {
            return back()->withErrors([
                'error_general' => 'Ocurrió un error interno: ' . $e->getMessage()
            ]);
        }

        return back()->with('message', 'Categoría actualizada con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CategoriaProductos $categoriaProductos)
    {
        try {
            $categoriaProductos->delete();
        } catch (\Exception $e) {
            return back()->withErrors([
                'error_general' => 'Ocurrió un error interno: ' . $e->getMessage()
            ]);
        }

        return back()->with('message', 'Categoría Eliminada con éxito');
    }
}

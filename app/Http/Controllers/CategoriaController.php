<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorias = Categoria::latest()->get();

        return Inertia::render("catalogue/category/Index", [
            'categorias' => $categorias
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
            Categoria::create($validated);
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
    public function update(Request $request, Categoria $categoria)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:50',
            'descripcion' => 'nullable|string|max:155',
        ]);

        try {
            $categoria->update($validated);
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
    public function destroy(Categoria $categoria) {}
}

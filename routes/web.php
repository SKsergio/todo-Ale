<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CategoriaProductoController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('task-category', [CategoriaController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('task-category'); 

Route::middleware(['auth', 'verified'])->group(function(){
    Route::get('/task-category', [CategoriaController::class, 'index'])->name('task-category');
    Route::post('/categorias', [CategoriaController::class, 'store']);
    Route::put('/categorias/{categoria}', [CategoriaController::class, 'update']);
    Route::delete('/categorias/{categoria}', [CategoriaController::class, 'destroy']);
});

Route::get('product-category', [CategoriaProductoController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('product-category');

Route::middleware(['auth', 'verified'])->group(function(){
    Route::get('/product-category', [CategoriaProductoController::class, 'index'])->name('product-category');
    Route::post('/product-category', [CategoriaProductoController::class, 'store']);
    Route::put('/product-category/{categoria}', [CategoriaProductoController::class, 'update']);
    Route::delete('/product-category/{categoria}', [CategoriaProductoController::class, 'destroy']);
});

require __DIR__ . '/settings.php';

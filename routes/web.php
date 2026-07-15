<?php

use App\Http\Controllers\CategoriaController;
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

require __DIR__ . '/settings.php';

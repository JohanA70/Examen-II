<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ParqueController;

Route::get('/', function () {
    return view('Home');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/comentarios/rating/{minRating}/{maxRating}', [ParqueController::class, 'getComentariosByRating']);
Route::get('/comentarios/count/{atraccionId}', [ParqueController::class, 'getComentariosCountByAtraccion']);
Route::get('/atracciones/especie/{especieId}', [ParqueController::class, 'getAtraccionesByEspecie']);
Route::get('/atracciones/avgRating/{especieId}', [ParqueController::class, 'getAvgRatingByEspecie']);

require __DIR__.'/auth.php';

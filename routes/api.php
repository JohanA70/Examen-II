<?php

use App\Http\Controllers\Api\ComentariosController;
use App\Http\Controllers\Api\UserComentariosController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

Route::post('/sanctum/token', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required',
    ]);
 
    $user = User::where('email', $request->email)->first();


    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }
 
    return $user->createToken($request->device_name)->plainTextToken;
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/especies', [ComentariosController::class, 'index'])->middleware('auth:sanctum');
Route::post('/comentarios', [ComentariosController::class, 'save'])->middleware('auth:sanctum');
Route::get('/especies/{id}', [ComentariosController::class, 'obtenerEspecies'])->middleware('auth:sanctum');
Route::put('/atraccion/{id}', [ComentariosController::class, 'updateAtraccion'])->middleware('auth:sanctum');

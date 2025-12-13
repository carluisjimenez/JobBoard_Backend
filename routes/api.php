<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\JobOfferController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\RecruiterApplicationController;

// Rutas de autenticación para los usuarios
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return response()->json($request->user());  // Devuelve el usuario autenticado
});
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
// ----------------------------------------------------------------------------





// Rutas exclusivas para los reclutadores
// Rutas de la API para las ofertas de trabajo
Route::middleware('auth:sanctum')->group(function () {
    // Crear
    Route::post('/job-offers', [JobOfferController::class, 'create']);

    // Listar todas las ofertas
    Route::get('/job-offers', [JobOfferController::class, 'index']);
    // Listar todas las ofertas que tienen postulaciones
    Route::get(
        '/job-offers/{offerId}/applications',
        [RecruiterApplicationController::class, 'index']
    );
    //Filtrar ofertas de trabajo por categoría y ubicación
    Route::get('/job-offers/search', [JobOfferController::class, 'search']);

    // Actualizar
    Route::put('/job-offers/{id}', [JobOfferController::class, 'update']);

    //Actualizar el estado de una postulación
    Route::put(
        '/job-applications/{applicationId}/approve',
        [RecruiterApplicationController::class, 'approve']
    );
    Route::patch('/job-offers/{id}', [JobOfferController::class, 'update']);

    // Eliminar
    Route::delete('/job-offers/{id}', [JobOfferController::class, 'destroy']);
});
// ----------------------------------------------------------------------------


// Rutas para los candidatos
Route::middleware('auth:sanctum')->group(function () {
    // Ofertas
    Route::get('/job-offers/all', [JobOfferController::class, 'all']);

    // Postulaciones
    Route::get('/job-applications', [JobApplicationController::class, 'index']);
    Route::post('/job-applications', [JobApplicationController::class, 'store']);
    Route::delete('/job-applications/{id}', [JobApplicationController::class, 'destroy']);
});

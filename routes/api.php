<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\UtilisateurController;
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// Route::apiResource('utilisateurs', UtilisateurController::class);

// Routes Utilisateurs
Route::get('/users', [UtilisateurController::class, 'index']);               
Route::post('/users', [UtilisateurController::class, 'store']);             
Route::get('/users/{id}', [UtilisateurController::class, 'show']);         
Route::put('/users/{id}', [UtilisateurController::class, 'update']);         
Route::delete('/users/{id}', [UtilisateurController::class, 'destroy']);     



//Routes Produits
Route::get('/produits', [ProduitController::class, 'index']);               
Route::post('/produits', [ProduitController::class, 'store']);              
Route::get('/produits/{id}', [ProduitController::class, 'show']);          
Route::put('/produits/{id}', [ProduitController::class, 'update']);         
Route::delete('/produits/{id}', [ProduitController::class, 'destroy']);     



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'conn_user']);
});



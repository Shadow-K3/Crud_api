<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\UtilisateurController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


//Routes Utilisateur
Route::apiResource('utilisateurs', UtilisateurController::class);


//Routes Produits
Route::apiResource('produits', ProduitController::class);

<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\Request;

class ProduitController extends Controller
{
   // LISTE DES PRODUITS
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'data' => Produit::all()
        ]);
    }

    // AJOUTER UN PRODUIT
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required',
            'prix' => 'required|integer',
            'stock' => 'required|integer',
        ]);

        $produit = Produit::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Produit créé avec succès',
            'data' => $produit
        ], 201);
    }

    // AFFICHER UN PRODUIT
    public function show($id)
    {
        $produit = Produit::find($id);

        if (!$produit) {
            return response()->json([
                'status' => 'error',
                'message' => 'Produit introuvable'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $produit
        ]);
    }

    // MODIFIER UN PRODUIT
    public function update(Request $request, $id)
    {
        $produit = Produit::find($id);

        if (!$produit) {
            return response()->json([
                'status' => 'error',
                'message' => 'Produit introuvable'
            ], 404);
        }

        $produit->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Produit modifié avec succès',
            'data' => $produit
        ]);
    }

    // SUPPRIMER UN PRODUIT
    public function destroy($id)
    {
        $produit = Produit::find($id);

        if (!$produit) {
            return response()->json([
                'status' => 'error',
                'message' => 'Produit introuvable'
            ], 404);
        }

        $produit->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Produit supprimé avec succès'
        ]);
    }
}

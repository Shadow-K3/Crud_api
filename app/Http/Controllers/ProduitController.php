<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Exception;

class ProduitController extends Controller
{
    // LISTE DES PRODUITS
    public function index()
    {
        try {
            $produits = Produit::all();

            return response()->json([
                'status' => 'success',
                'data' => $produits
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Erreur lors de la récupération des produits',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // AJOUTER UN PRODUIT
    public function store(Request $request)
    {
        try {
            // VALIDATION DES DONNÉES
            $validated = $request->validate([
                'nom'   => 'required',
                'prix'  => 'required|integer',
                'stock' => 'required|integer',
            ]);

            // CREATION DU PRODUIT
            $produit = Produit::create($validated);

            return response()->json([
                'status' => 'success',
                'message' => 'Produit créé avec succès',
                'data' => $produit
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Erreur lors de la création du produit',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // AFFICHER UN PRODUIT
    public function show($id)
    {
        try {
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
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Erreur lors de la récupération du produit',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // MODIFIER UN PRODUIT
    public function update(Request $request, $id)
    {
        try {
            $produit = Produit::find($id);

            if (!$produit) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Produit introuvable'
                ], 404);
            }

            // MISE À JOUR
            $produit->update($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Produit modifié avec succès',
                'data' => $produit
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Erreur lors de la modification du produit',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // SUPPRIMER UN PRODUIT
    public function destroy($id)
    {
        try {
            $produit = Produit::find($id);

            if (!$produit) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Produit introuvable'
                ], 404);
            }

            // SUPPRESSION
            $produit->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Produit supprimé avec succès'
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Erreur lors de la suppression du produit',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

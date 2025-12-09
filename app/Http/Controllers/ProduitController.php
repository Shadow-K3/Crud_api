<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\Request;

class ProduitController extends Controller
{
    // LISTE DES PRODUITS
    public function index()
    {
        return Produit::all();
    }

    // AJOUTER UN PRODUIT
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'prix' => 'required|integer',
            'stock' => 'required|integer',
        ]);

        return Produit::create($request->all());
    }

    // AFFICHER UN PRODUIT
    public function show($id)
    {
        return Produit::findOrFail($id);
    }

    // MODIFIER UN PRODUIT
    public function update(Request $request, $id)
    {
        $produit = Produit::findOrFail($id);
        $produit->update($request->all());
        return $produit;
    }

    // SUPPRIMER UN PRODUIT
    public function destroy($id)
    {
        Produit::findOrFail($id)->delete();
        return response()->json(['message' => 'Produit supprimé']);
    }
}

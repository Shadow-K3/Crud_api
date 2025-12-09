<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use Illuminate\Http\Request;

class UtilisateurController extends Controller
{
    // LISTE DES UTILISATEURS
    public function index()
    {
        return Utilisateur::all();
    }

    // AJOUTER UN UTILISATEUR
    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'nom' => 'required',
            'email' => 'required|email|unique:utilisateurs',
            'password' => 'required',
        ]);

        // Création
        return Utilisateur::create($request->all());
    }

    // AFFICHER UN UTILISATEUR
    public function show($id)
    {
        return Utilisateur::findOrFail($id);
    }

    // MODIFIER UN UTILISATEUR
    public function update(Request $request, $id)
    {
        $user = Utilisateur::findOrFail($id);
        $user->update($request->all());
        return $user;
    }

    // SUPPRIMER UN UTILISATEUR
    public function destroy($id)
    {
        Utilisateur::findOrFail($id)->delete();
        return response()->json(['message' => 'Utilisateur supprimé']);
    }
}

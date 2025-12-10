<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;

class UtilisateurController extends Controller
{
    // LISTE DES UTILISATEURS
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'data' => Utilisateur::all()
        ]);
    }

    // AJOUTER UN UTILISATEUR
    public function store(Request $request)
    {
        // VALIDATION
        $validated = $request->validate([
            'nom' => 'required',
            'email' => 'required|email|unique:utilisateurs',
            'password' => 'required|min:4',
        ]);

        // HASH DU PASSWORD
        $validated['password'] = Hash::make($validated['password']);

        // CREATION
        $user = Utilisateur::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Utilisateur créé avec succès',
            'data' => $user
        ], 201);
    }

    // AFFICHER UN UTILISATEUR
    public function show($id)
    {
        $user = Utilisateur::find($id);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Utilisateur introuvable'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $user
        ]);
    }

    // MODIFIER UN UTILISATEUR
    public function update(Request $request, $id)
    {
        $user = Utilisateur::find($id);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Utilisateur introuvable'
            ], 404);
        }

        // SI LE MOT DE PASSE EST CHANGÉ → HASH
        if ($request->has('password')) {
            $request['password'] = Hash::make($request->password);
        }

        $user->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Utilisateur modifié avec succès',
            'data' => $user
        ]);
    }

    // SUPPRIMER UN UTILISATEUR
    public function destroy($id)
    {
        $user = Utilisateur::find($id);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Utilisateur introuvable'
            ], 404);
        }

        $user->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Utilisateur supprimé avec succès'
        ]);
    }
}

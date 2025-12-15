<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Exception;

class UtilisateurController extends Controller
{
    // LISTE DES UTILISATEURS
    public function index()
    {
        try {
            $utilisateurs = Utilisateur::all();

            return response()->json([
                'status' => 'success',
                'data' => $utilisateurs
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Erreur lors de la récupération des utilisateurs',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // AJOUTER UN UTILISATEUR
    public function store(Request $request)
    {
        try {
            // VALIDATION
            $validated = $request->validate([
                'nom' => 'required',
                'email' => 'required|email|unique:utilisateurs',
                'password' => 'required|min:4',
            ]);

            // HASH PASSWORD
            $validated['password'] = Hash::make($validated['password']);

            // CREATION
            $user = Utilisateur::create($validated);

            return response()->json([
                'status' => 'success',
                'message' => 'Utilisateur créé avec succès',
                'data' => $user
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Erreur lors de la création de l’utilisateur',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // AFFICHER UN UTILISATEUR
    public function show($id)
    {
        try {
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
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Erreur lors de la récupération de l’utilisateur',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // MODIFIER UN UTILISATEUR
    public function update(Request $request, $id)
    {
        try {
            $user = Utilisateur::find($id);

            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Utilisateur introuvable'
                ], 404);
            }

            // HASH PASSWORD SI PRÉSENT
            if ($request->filled('password')) {
                $request->merge([
                    'password' => Hash::make($request->password)
                ]);
            }

            $user->update($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Utilisateur modifié avec succès',
                'data' => $user
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Erreur lors de la modification de l’utilisateur',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // SUPPRIMER UN UTILISATEUR
    public function destroy($id)
    {
        try {
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
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Erreur lors de la suppression de l’utilisateur',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

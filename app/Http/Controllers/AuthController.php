<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Exception;

class AuthController extends Controller
{
    // INSCRIPTION
    public function register(Request $request)
    {
        try {
            $validated = $request->validate([
                'nom' => 'required',
                'email' => 'required|email|unique:utilisateurs',
                'password' => 'required|min:4'
            ]);

            $validated['password'] = Hash::make($validated['password']);

            $user = Utilisateur::create($validated);

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'status' => 'success',
                'message' => 'Compte créé',
                'token' => $token,
                'user' => $user
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Erreur inscription',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // CONNEXION
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            $user = Utilisateur::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Identifiants incorrects'
                ], 401);
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'status' => 'success',
                'token' => $token,
                'user' => $user
            ]);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Erreur connexion',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // UTILISATEUR CONNECTÉ
    public function conn_user(Request $request)
    {
        return response()->json([
            'status' => 'success',
            'user' => $request->user()
        ]);
    }

    // DÉCONNEXION
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Déconnexion réussie'
        ]);
    }
}

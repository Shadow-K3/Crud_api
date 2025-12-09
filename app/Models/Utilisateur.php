<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Utilisateur extends Model
{
    //
    // Nom de la table
    protected $table = 'utilisateurs';

    // Champs modifiables
    protected $fillable = [
        'nom',
        'email',
        'password',
    ];

    // Masquer le mot de passe dans les réponses JSON
    protected $hidden = [
        'password'
    ];
}

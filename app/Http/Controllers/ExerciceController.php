<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exercice;

class ExerciceController extends Controller
{
    public function store(Request $request)
    {
        // Valider les données envoyées
        $request->validate([
            'titre' => 'required|string|max:255',
            'propos' => 'nullable|string',
            'is_true' => 'required|boolean'
        ]);

        // Insérer dans la base de données
        $exercice = Exercice::create([
            'titre' => $request->titre,
            'propos' => $request->propos,
            'is_true' => $request->is_true
        ]);

        // Retourner une réponse JSON
        return response()->json([
            'message' => 'Exercice ajouté avec succès',
            'exercice' => $exercice
        ], 201);
    }
}

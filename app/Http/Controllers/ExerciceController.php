<?php

namespace App\Http\Controllers;
// app/Http/Controllers/ExerciceController.php

namespace App\Http\Controllers;

use App\Models\Exercice;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ExerciceController extends Controller
{
    // Afficher tous les exercices
    public function index()
    {
        $exercices = Exercice::with('propositions')->get(); // Récupérer tous les exercices
        return Inertia::render('Examens/Exercices/ExerciceList', ['exercices' => $exercices]);
    }
  
    // Afficher un exercice spécifique
    public function show($id)
    {
        $exercice = Exercice::with('propositions')->find($id);
                if (!$exercice) {
            abort(404, 'Exercice non trouvé');
        }
        return Inertia::render('Examens/Exercices/ExerciceDetail', ['exercice' => $exercice]);
    }

    // Créer un nouvel exercice
    public function create()
    {
        return Inertia::render('Examens/Exercices/CreateExercice');
    }

    // Enregistrer un nouvel exercice dans la base de données
    public function store(Request $request)
{
    // Validation des données
    $request->validate([
        'titre' => 'required|string|max:255',
        'propositions' => 'required|array|min:1',
        'propositions.*.text' => 'required|string|max:255', // Assurez-vous que le champ est bien 'text'
        'propositions.*.is_true' => 'required|boolean',
    ]);

    // Création de l'exercice
    $exercice = Exercice::create([
        'titre' => $request->titre,
    ]);

    // Enregistrement des propositions
    foreach ($request->propositions as $proposition) {
        $exercice->propositions()->create([
            'propos' => $proposition['text'], // Assurez-vous que le champ est bien 'text'
            'is_true' => $proposition['is_true'],
        ]);
    }

    return redirect()->route('exercice.index')->with('success', 'Exercice créé avec succès');
}

    // Afficher le formulaire d'édition d'un exercice
    // app/Http/Controllers/ExerciceController.php
public function edit($id)
{
    // Récupérer l'exercice avec ses propositions
    $exercice = Exercice::with('propositions')->find($id);

    if (!$exercice) {
        abort(404, 'Exercice non trouvé');
    }

    // Passer l'exercice à la vue
    return Inertia::render('Examens/Exercices/EditExercice', ['exercice' => $exercice]);
}

    // Mettre à jour un exercice existant
    // app/Http/Controllers/ExerciceController.php
public function update(Request $request, $id)
{
    // Validation des données
    $request->validate([
        'titre' => 'required|string|max:255',
        'propositions' => 'required|array|min:1',
        'propositions.*.propos' => 'required|string|max:255',
        'propositions.*.is_true' => 'required|boolean',
    ]);

    // Récupérer l'exercice
    $exercice = Exercice::find($id);

    if (!$exercice) {
        abort(404, 'Exercice non trouvé');
    }

    // Mettre à jour l'exercice
    $exercice->update([
        'titre' => $request->titre,
    ]);

    // Supprimer les anciennes propositions
    $exercice->propositions()->delete();

    // Enregistrer les nouvelles propositions
    foreach ($request->propositions as $proposition) {
        $exercice->propositions()->create([
            'propos' => $proposition['propos'],
            'is_true' => $proposition['is_true'],
        ]);
    }

    // Rediriger vers la liste des exercices avec un message de succès
    return redirect()->route('exercice.index')->with('success', 'Exercice mis à jour avec succès');
}

    // Supprimer un exercice
   
    public function destroy($id)
    {
        $exercice = Exercice::find($id);
    
        if (!$exercice) {
            return response()->json(['message' => 'Exercice introuvable'], 404);
        }
    
        $exercice->delete();
    
        return response()->json(['message' => 'Exercice supprimé avec succès'], 200);
    }

public function getResultats(Request $request)
{
    $exercices = $request->input('exercices');
    $selectedPropositions = $request->input('selectedPropositions');

    $score = 0;

    foreach ($exercices as $exercice) {
        $selectedPropositionId = $selectedPropositions[$exercice['id']] ?? null;
        if ($selectedPropositionId !== null) {
            $selectedProposition = collect($exercice['propositions'])->firstWhere('id', $selectedPropositionId);
            if ($selectedProposition && $selectedProposition['is_true']) {
                $score += 1;
            }
        }
    }

    $totalQuestions = count($exercices);
    $finalScore = ($score / $totalQuestions) * 100;

    $message = '';
    if ($finalScore >= 80) {
        $message = 'Bravo ! Vous avez excellé.';
    } elseif ($finalScore >= 50) {
        $message = 'Pas mal, mais vous pouvez faire mieux.';
    } else {
        $message = 'Dommage, essayez encore.';
    }

    return response()->json([
        'score' => $score,
        'totalQuestions' => $totalQuestions,
        'message' => $message,
        'finalScore' => $finalScore,
    ]);
}

}


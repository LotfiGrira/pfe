<?php

namespace App\Http\Controllers;


use App\Models\Question;
use App\Models\Proposition;
use App\Models\Examen;
use Illuminate\Http\Request;
use Inertia\Inertia;

class QuestionController extends Controller
{
    // Afficher tous les questions

    public function index(Examen $examen)
{
    return Inertia::render('Examens/Questions/AffichageQuestion', [
        'questions' => $examen->questions()->with('propositions')->get(),
        'examenId' => $examen->id, // ✅ Ceci est obligatoire
    ]);
}



    // Afficher un questions spécifique
    public function show(Examen $examen)
{
    $questions = $examen->questions()->with('propositions')->get();

    return Inertia::render('Examens/Questions/AffichageQuestion', [
        'examenId' => $examen->id,
        'questions' => $questions,
    ]);
}




    // Créer un nouvel question
    public function create($examen)
{
    return Inertia::render('Examens/Questions/CreateQuestion', [
        'examenId' => (int) $examen,
    ]);
}
    



    
    // Enregistrer un nouvel Questions dans la base de données
    public function store(Request $request, $examenId)
{
    $validated = $request->validate([
        'titre' => 'required|string|max:255',
        'propositions' => 'required|array|min:1',
        'propositions.*.propos' => 'required|string|max:255',
        'propositions.*.is_true' => 'required|boolean',
    ]);

    // Création de la question
    $question = Question::create([
        'titre' => $validated['titre'],
        'examen_id' => $examenId,
    ]);

    // Création des propositions associées
    foreach ($validated['propositions'] as $prop) {
        $question->propositions()->create([
            'propos' => $prop['propos'],
            'is_true' => $prop['is_true'],
        ]);
    }

    return redirect()
        ->route('examens.questions.index', ['examen' => $examenId])
        ->with('success', 'Question créée avec succès.');
}
    

    // Afficher le formulaire d'édition d'un Questions
    
    public function edit(Examen $examen, $questionId)
    {
        $question = $examen->questions()->with('propositions')->findOrFail($questionId);
    
        return Inertia::render('Examens/Questions/Edit', [
            'examenId' => $examen->id,
            'question' => $question,
        ]);
    }

    // Mettre à jour un question existant
    public function update(Request $request, $examenId, $questionId)
{
    $validated = $request->validate([
        'titre' => 'required|string|max:255',
        'propositions' => 'required|array|min:1',
        'propositions.*.propos' => 'required|string|max:255',
        'propositions.*.is_true' => 'required|boolean',
    ]);

    $question = Question::findOrFail($questionId);
    $question->update([
        'titre' => $validated['titre'],
        'examen_id' => $examenId,
    ]);

    // Recréer les propositions
    $question->propositions()->delete();
    foreach ($validated['propositions'] as $prop) {
        $question->propositions()->create($prop);
    }

    return redirect()
        ->route('examens.questions.index', ['examen' => $examenId])
        ->with('success', 'Question modifiée avec succès.');
    }
    // Supprimer un question
   
    public function destroy($examenId, $questionId)
{
    $question = Question::findOrFail($questionId);
    $question->delete();

    return redirect()->back()->with('success', 'Question supprimée avec succès.');
}

public function getResultats(Request $request)
{
    $questions = $request->input('questions');
    $selectedPropositions = $request->input('selectedPropositions');

    $score = 0;

    foreach ($questions as $question) {
        $selectedPropositionId = $selectedPropositions[$question['id']] ?? null;
        if ($selectedPropositionId !== null) {
            $selectedProposition = collect($question['propositions'])->firstWhere('id', $selectedPropositionId);
            if ($selectedProposition && $selectedProposition['is_true']) {
                $score += 1;
            }
        }
    }

    $totalQestions = count($questions);
    $finalScore = ($score / $totalQestions) * 100;

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
        'totalQestions' => $totalQestions,
        'message' => $message,
        'finalScore' => $finalScore,
    ]);
}
public function affichage($examenId)
{
    $questions = Question::with('propositions')
        ->where('examen_id', $examenId)
        ->get();

    return Inertia::render('Examens/Questions/AffichageQuestion', [
        'questions' => $questions,
        'examenId' => (int) $examenId,
    ]);
}


public function liste($examenId)
{
    $examen = Examen::with(['questions.propositions'])->findOrFail($examenId);

    return Inertia::render('Examens/Questions/QuestionList', [
        'examenTitre' => $examen->titre,
        'questions' => $examen->questions,
    ]);
}
}

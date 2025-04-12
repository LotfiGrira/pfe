<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use Inertia\Inertia;

class QuestionController extends Controller
{
    // Afficher tous les questions
    
  
    public function index()
{
    $questions = Question::with('propositions')->get();
    return Inertia::render('Examens/Questions/QuestionList', ['questions' => $questions]);
}

    // Afficher un questions spécifique
    public function show($id)
    {
        $question = Question::with('propositions')->find($id);
                if (!$question) {
            abort(404, 'Question non trouvé');
        }
        return Inertia::render('Examens/Questions/QuestionDetail', ['question' => $question]);
    }

    // Créer un nouvel question
    public function create()
    {
        return Inertia::render('Examens/Questions/CreateQuestion');
    }

    // Enregistrer un nouvel Questions dans la base de données
    public function store(Request $request)
{
    // Validation des données
    $request->validate([
        'titre' => 'required|string|max:255',
        'propositions' => 'required|array|min:1',
        'propositions.*.text' => 'required|string|max:255', // Assurez-vous que le champ est bien 'text'
        'propositions.*.is_true' => 'required|boolean',
    ]);

    // Création de l'Questions
    $question = Question::create([
        'titre' => $request->titre,
    ]);

    // Enregistrement des propositions
    foreach ($request->propositions as $proposition) {
        $question->propositions()->create([
            'propos' => $proposition['text'], // Assurez-vous que le champ est bien 'text'
            'is_true' => $proposition['is_true'],
        ]);
    }

    return redirect()->route('question.index')->with('success', 'Question créé avec succès');
}

    // Afficher le formulaire d'édition d'un Questions
    
public function edit($id)
{
    // Récupérer l'Questions avec ses propositions
    $question = question::with('propositions')->find($id);

    if (!$question) {
        abort(404, 'Question non trouvé');
    }

    // Passer l'question à la vue
    return Inertia::render('Examens/Questions/EditQuestion', ['question' => $question]);
}

    // Mettre à jour un question existant
public function update(Request $request, $id)
{
    // Validation des données
    $request->validate([
        'titre' => 'required|string|max:255',
        'propositions' => 'required|array|min:1',
        'propositions.*.propos' => 'required|string|max:255',
        'propositions.*.is_true' => 'required|boolean',
    ]);

    // Récupérer l'question
    $question = Question::find($id);

    if (!$question) {
        abort(404, 'Question non trouvé');
    }

    // Mettre à jour l'question
    $question->update([
        'titre' => $request->titre,
    ]);

    // Supprimer les anciennes propositions
    $question->propositions()->delete();

    // Enregistrer les nouvelles propositions
    foreach ($request->propositions as $proposition) {
        $question->propositions()->create([
            'propos' => $proposition['propos'],
            'is_true' => $proposition['is_true'],
        ]);
    }

    // Rediriger vers la liste des question avec un message de succès
    return redirect()->route('question.index')->with('success', 'Question mis à jour avec succès');
}

    // Supprimer un question
   
    public function destroy($id)
    {
        $question = Question::find($id);
    
        if (!$question) {
            return response()->json(['message' => 'Question introuvable'], 404);
        }
    
        $question->delete();
    
        return response()->json(['message' => 'Question supprimé avec succès'], 200);
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

}


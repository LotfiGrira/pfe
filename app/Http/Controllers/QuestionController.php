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
            'examenId' => $examen->id,
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
    public function create($examenId)
    {
        // Récupérer l'examen
        $examen = Examen::findOrFail($examenId);
    
        // Passer l'examenId à la vue
        return Inertia::render('Examens/Questions/CreateQuestion', [
            'examenId' => $examen->id
        ]);
    }
    



    
    // Enregistrer un nouvel Questions dans la base de données
    public function store(Request $request, $examenId)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'propositions' => 'required|array|min:2',
            'propositions.*.propos' => 'required|string',
            'propositions.*.is_true' => 'required|boolean',
        ]);
    
        // Créer la question
        $question = Question::create([
            'titre' => $request->titre,
            'examen_id' => $examenId,
        ]);
    
        // Créer les propositions associées
        foreach ($request->propositions as $prop) {
            Proposition::create([
                'question_id' => $question->id,
                'propos' => $prop['propos'],
                'is_true' => $prop['is_true'],
            ]);
        }
    
        // ✅ Redirection vers la page de l'examen (affichage de l'examen avec ses questions, par exemple)
        return redirect()->route('examens.show', $examenId)
                         ->with('success', 'Question créée avec succès !');
    }
    

    // Afficher le formulaire d'édition d'un Questions
    
    public function edit(Examen $examen, Question $question)
    {
        return Inertia::render('Examens/Questions/Edit', [
            'examenId' => $examen->id,
            'question' => $question->load('propositions'),
        ]);
    }

    // Mettre à jour un question existant
    public function update(UpdateQuestionRequest $request, Examen $examen, Question $question)
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
    return redirect()->route('examen/question.affichage')->with('success', 'Question mis à jour avec succès');

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

public function affichage()
{
    $questions = Question::select('id', 'titre')->get();

    return Inertia::render('Examens/Questions/AffichageQuestion', [
        'questions' => $questions,
    ]);
}
}


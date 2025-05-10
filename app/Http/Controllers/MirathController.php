<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MirathService;
use App\Services\HalService;
use App\Data\MirathInput; // Changement ici, on importe la bonne classe
use Inertia\Inertia;

class MirathController extends Controller
{
    public function calculateMirath(Request $request)
    {
        // Validation des entrées
        $validated = $request->validate([
            'gender' => 'required|in:ذكر,أنثى',
            'tarika' => 'required|numeric|min:0',
            'doyon' => 'nullable|numeric|min:0',
            'wasiya' => 'nullable|numeric|min:0',
        ]);

        // Création de l'objet de données à partir de la requête
        $input = new MirathInput($request->all()); // Modifié ici

        // Initialisation des services nécessaires
        $halService = new HalService();
        $mirathService = new MirathService($input, $halService);

        // Calcul des résultats
        $results = [];

        $results['azawja'] = $mirathService->mirathAzawja();
        $results['aljad'] = $mirathService->mirathAljad();
        $results['alom'] = $mirathService->mirathAlom();
        $results['aljadat'] = $mirathService->mirathAljadat();
        $results['awlad_alom'] = $mirathService->mirathAwladAlom();

        // Retourner les résultats sous forme de réponse JSON
        return response()->json([
            'results' => $results,
            'message' => 'Calcul du mirath terminé avec succès.',
        ]);
    }

    public function showResults()
    {
        return Inertia::render('ResultsPage');
    }
}

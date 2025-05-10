<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MirathService;
use App\Data\MirathInput; // Changement ici, on importe la bonne classe
use Inertia\Inertia;

class MirathController extends Controller
{
    protected $mirathService;

    public function __construct(MirathService $mirathService)
    {
        $this->mirathService = $mirathService;
    }

    public function showPageCasHeritier()
    {
        return Inertia::render('Miraths/CasHeritier');
    }

    public function calculateMirath(Request $request)
    {
        // Création de l'objet de données à partir de la requête
        $mirathInput = new MirathInput($request->all());

        // Calcul des résultats
        $rapport = [];

        $rapport = $this->mirathService->calculMirath($mirathInput);

        return Inertia::render('Miraths/resulatMirath', [
            'result' => $rapport,
        ]);

    }

    public function showResults()
    {
        return Inertia::render('ResultsPage');
    }
}

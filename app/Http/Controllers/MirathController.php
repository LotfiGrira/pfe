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
        $data = $request->all();
        // Calcul des résultats
        $rapport = [];

        $rapport = $this->mirathService->calculMirath($data["mirathInput"]);

        return Inertia::render('Miraths/CasHeritierResult', [
            'result' => $rapport,
        ]);

    }

    public function showResults()
    {
        return Inertia::render('ResultsPage');
    }
}

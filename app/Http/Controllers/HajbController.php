<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\HajbService;
use App\Data\InputData;

class HajbController extends Controller
{
    public function calculateHajb(Request $request)
    {
        $input = new InputData($request->all()); // Gère les entrées de l'utilisateur
        $hajbService = new HajbService($input);
        $hajbService->hajbBiAlab();

        return response()->json(['message' => 'Calcul du Hajb terminé avec succès']);
    }
}

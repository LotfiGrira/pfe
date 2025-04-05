<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MirathService;
use App\Services\HalService;
use App\Data\InputData;

class MirathController extends Controller
{
    public function calculateMirath(Request $request)
    {
        $input = new InputData($request->all()); // Gère les entrées de l'utilisateur
        $hal = new HalService(); // Service pour suivre l'état des héritiers

        $mirathService = new MirathService($input, $hal);
        $mirathService->mirathAzawja();

        $mirathService = new MirathService($input);
        $mirathService->mirathAljad();

        $mirathService = new MirathService($request->all());
        $mirathService->mirathAlom();
        
    
        $mirathService = new MirathService($request->all());
        $mirathService ->mirathAljadat();

        $mirathService = new MirathService($request->all());
        $mirathService -> mirathAwladAlom();

       
      
    


        return response()->json(['message' => 'Calcul du mirath terminé avec succès']);
    }
}

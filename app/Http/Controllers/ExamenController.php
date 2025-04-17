<?php

namespace App\Http\Controllers;

use App\Models\Examen;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ExamenController extends Controller
{

public function create(): Response
{
    return Inertia::render('Examens/Examen/CreateExamen');
}

public function store(Request $request)
{
    $request->validate([
        'titre' => 'required|string|max:255',
    ]);

    Examen::create([
        'titre' => $request->titre,
    ]);

    return redirect()->route('examens.index')->with('success', 'Examen créé avec succès.');
}
public function index()
{
    $examens = Examen::all();
    return Inertia::render('Examens/Examen/Index', ['examens' => $examens]);
}
public function edit($id)
{
    $examen = Examen::findOrFail($id);
    return Inertia::render('Examens/Examen/EditExamen', [
        'examen' => $examen,
    ]);
}
public function update(Request $request, $id)
{
    $request->validate([
        'titre' => 'required|string|max:255',
    ]);

    $examen = Examen::findOrFail($id);
    $examen->update([
        'titre' => $request->titre,
    ]);

    return redirect()->route('examens.index')->with('success', 'Examen mis à jour avec succès.');
}
   
public function destroy($id)
{
    $examen = Examen::findOrFail($id);
    $examen->delete();

    return redirect()->route('examens.index')->with('success', 'Examen supprimé avec succès.');
}



}
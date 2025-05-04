<?php

namespace App\Http\Controllers;

use App\Models\Examen; // ✅ ICI
use Inertia\Inertia;
use Illuminate\Http\Request;
use Inertia\Response;

class ExamenController extends Controller

{

public function create()
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
    $isAdmin = auth()->user()->hasRole('admin');

    return Inertia::render('Examens/Examen/Index', [
        'examens' => $examens,
        'isAdmin' => $isAdmin,
    ]);
}
public function listeexamen()
{
    $examens = Examen::all();

    return Inertia::render('Examens/Examen/ListeExamen', [
        'examens' => $examens,
    ]);
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
public function __construct()
{
    // $this->middleware('role:admin'); // Vérifie que l'utilisateur a le rôle "admin"
}
public function show($id)
{
    $examen = Examen::findOrFail($id);

    return Inertia::render('Examens/Questions/AffichageQuestion', [
        'examen' => $examen,
    ]);
}


public function affichage()
{
$examens = Examen::all();

    return Inertia::render('Examens/Examen/AffichageExamen', [
        'examens' => Examen::all(),
        
    ]);

}

}

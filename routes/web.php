<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AboutController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ExerciceController;
use App\Http\Controllers\ListeHeritierController;



Route::get('/', function () {
    return redirect()->route("about");
});



// Routes pour les exercices
// Page de création d'un exercice
Route::get('/exercices/create',  [ExerciceController::class, 'create']);
Route::post('/exercices', [ExerciceController::class, 'store'])->name('exercice.store');
Route::get('/exercices', [ExerciceController::class, 'index'])->name('exercice.index');
Route::get('/exercices/{id}', [ExerciceController::class, 'show'])->name('exercice.show');
Route::get('/exercices/{id}/edit', [ExerciceController::class, 'edit'])->name('exercice.edit');
Route::put('/exercices/{id}', [ExerciceController::class, 'update'])->name('exercice.update');
Route::delete('/exercices/{id}', [ExerciceController::class, 'destroy'])->name('exercice.destroy');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Routes pour le profil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route pour la page "À propos"
Route::get('/about', [AboutController::class, "index"])->name("about");

require __DIR__.'/auth.php';





// Route::get('/exercices/create', [ExerciceController::class, 'create']);
Route::post('/resultats', [ExerciceController::class, 'getResultats']);

Route::get('/calculator', function () {
    return Inertia::render('NewCalcule'); // Vérifiez si ça pointe vers "NewCalcule"
});
Route::get('/liste-heritier', function () {
    return Inertia::render('ListeHeritier'); // Vérifiez si ça pointe vers "NewCalcule"
});
Route::get('/cas-heritier', function () {
    return Inertia::render('CasHeritier'); 
});
Route::get('/Monasa5atHeritier', function () {
    return Inertia::render('Monasa5atHeritier');
})->name('monasa5at.heritier');

Route::get('/HamelHeritier', function () {
    return Inertia::render('HamelHeritier');
})->name('hamel.heritier');
Route::get('/WasiyaHeritier', function () {
    return Inertia::render('WasiyaHeritier');
})->name('wasiya.heritier');
Route::get('/MafgodHeritier', function () {
    return Inertia::render('MafgodHeritier');
})->name('mafgod.heritier');
Route::get('/GatelHeritier', function () {
    return Inertia::render('GatelHeritier');
})->name('gatel.heritier');
Route::get('/KaferHeritier', function () {
    return Inertia::render('KaferHeritier');
})->name('kafer.heritier');
Route::get('/tagsim-heritier', function () {
    return Inertia::render('TagsimHeritier');
})->name('tagsim-heritier');
Route::get('/liste-monasa5at', function () {
    return Inertia::render('ListeMonasa5at'); 
});

Route::get('/listeheritier', [ListeHeritierController::class, 'index'])->name('listeheritier');

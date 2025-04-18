<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AboutController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ListeHeritierController;
use App\Http\Controllers\ExamenController;



Route::get('/', function () {
    return redirect()->route("about");
});



// Routes pour les Questions

Route::get('/examens/{examen}/questions/create', [QuestionController::class, 'create'])->name('questions.create');
Route::post('/examens/{examen}/questions', [QuestionController::class, 'store'])->name('question.store');
Route::get('/examens/{examen}/questions', [QuestionController::class, 'index'])->name('question.index');
Route::post('/examens/{examen}/questions', [QuestionController::class, 'store'])
    ->name('examens.questions.store');
    Route::get('/examens/{examen}', [QuestionController::class, 'index'])->name('examens.questions.index');

Route::get('/examens/{examen}/questions/affichage', [QuestionController::class, 'affichage'])
    ->name('question.affichage');
    Route::get('/examens/{examen}/questions/{id}', [QuestionController::class, 'show'])->name('question.show');
Route::get('/examens/{examen}/questions/{id}/edit', [QuestionController::class, 'edit'])->name('question.edit');
Route::put('/examens/{examen}/questions/{id}', [QuestionController::class, 'update'])->name('questions.update');
Route::delete('/examens/{examen}/questions/{id}', [QuestionController::class, 'destroy'])->name('examens.questions.destroy');


// Routes pour les Examens

Route::get('examens/create', [ExamenController::class, 'create'])->name('examen.create');
Route::post('/examens', [ExamenController::class, 'store'])->name('examen.store');
Route::get('/examens', [ExamenController::class, 'index'])->name('examens.index');
Route::get('/examens/{id}', [ExamenController::class, 'show'])->name('examens.show');
Route::get('/examens/{id}/edit', [ExamenController::class, 'edit'])->name('examens.edit');
Route::put('/examens/{id}', [ExamenController::class, 'update'])->name('examens.update');
Route::delete('/examens/{id}', [ExamenController::class, 'destroy'])->name('examens.destroy');



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





Route::post('/resultats', [QuestionsController::class, 'getResultats']);

Route::get('/calculator', function () {
    return Inertia::render('Miraths/NewCalcule'); // Vérifiez si ça pointe vers "NewCalcule"
});
Route::get('/liste-heritier', function () {
    return Inertia::render('Miraths/ListeHeritier'); // Vérifiez si ça pointe vers "NewCalcule"
});
Route::get('/cas-heritier', function () {
    return Inertia::render('Miraths/CasHeritier'); 
});
Route::get('/Monasa5atHeritier', function () {
    return Inertia::render('Miraths/Monasa5atHeritier');
})->name('monasa5at.heritier');

Route::get('/HamelHeritier', function () {
    return Inertia::render('Miraths/HamelHeritier');
})->name('hamel.heritier');
Route::get('/WasiyaHeritier', function () {
    return Inertia::render('Miraths/WasiyaHeritier');
})->name('wasiya.heritier');
Route::get('/MafgodHeritier', function () {
    return Inertia::render('Miraths/MafgodHeritier');
})->name('mafgod.heritier');
Route::get('/GatelHeritier', function () {
    return Inertia::render('Miraths/GatelHeritier');
})->name('gatel.heritier');
Route::get('/KaferHeritier', function () {
    return Inertia::render('Miraths/KaferHeritier');
})->name('kafer.heritier');
Route::get('/tagsim-heritier', function () {
    return Inertia::render('Miraths/TagsimHeritier');
})->name('tagsim-heritier');
Route::get('/liste-monasa5at', function () {
    return Inertia::render('Miraths/ListeMonasa5at'); 
});

Route::get('/listeheritier', [ListeHeritierController::class, 'index'])->name('listeheritier');

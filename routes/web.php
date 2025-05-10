<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\MirathController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ListeHeritierController;
use App\Http\Controllers\ExamenController;
use App\Http\Controllers\ArticleController;

Route::middleware(['auth'])->group(function () {
    Route::group(["middlleware" => ["verified"]], function () {
        Route::get('/dashboard', function () {
            return Inertia::render('Dashboard');
        })->name('dashboard');
    });

    Route::group(['middleware' => ['role:admin']], function () {

        Route::get('/examens', [ExamenController::class, 'index'])->name('examens.index');
        Route::get('/examen/create', [ExamenController::class, 'create'])->name('examens.create');
        Route::post('/examens', [ExamenController::class, 'store'])->name('examens.store');
        Route::get('/examens/{id}/edit', [ExamenController::class, 'edit'])->name('examens.edit');
        Route::put('/examens/{id}', [ExamenController::class, 'update'])->name('examens.update');
        Route::delete('/examens/{id}', [ExamenController::class, 'destroy'])->name('examens.destroy');

        Route::post('/examens/{examen}/questions', [QuestionController::class, 'store'])->name('examens.questions.store');
        Route::get('/examens/{examen}/questions/create', [QuestionController::class, 'create'])->name('questions.create');
        Route::get('/examens/{examen}/questions', [QuestionController::class, 'index'])->name('examens.questions.index');
        Route::get('/examens/{examen}/questions/{id}/edit', [QuestionController::class, 'edit'])->name('questions.edit');
        Route::put('/examens/{examen}/questions/{id}', [QuestionController::class, 'update'])->name('questions.update');
        Route::delete('/examens/{examen}/questions/{id}', [QuestionController::class, 'destroy'])->name('examens.questions.destroy');
        Route::get('/examens/{examen}/questions/affichage', [QuestionController::class, 'affichage'])->name('question.affichage');

        Route::get('/article/create', [ArticleController::class, 'create'])->name('articles.create');
        Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
        Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
        Route::get('/articles/{id}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
        Route::put('/articles/{id}', [ArticleController::class, 'update'])->name('articles.update');
        Route::delete('/articles/{id}', [ArticleController::class, 'destroy'])->name('articles.destroy');
    });
   
     Route::group(['middleware' => ['role:user']], function () {
        Route::get('/examens/liste', [ExamenController::class, 'listeexamen'])->name('examens.listeexamen');
        Route::get('/examens/affichage', [ExamenController::class, 'affichage'])->name('examens.affichage');
        Route::get('/examens/{id}', [ExamenController::class, 'show'])->name('examens.show');


        Route::get('/examens/{examen}/questions/{id}', [QuestionController::class, 'show'])->name('question.show');

        Route::get('/articles/liste', [ArticleController::class, 'liste'])->name('articles.liste');
        Route::get('/articles/{id}', [ArticleController::class, 'show'])->name('articles.show');
        Route::get('/articles/affichage', [ArticleController::class, 'affichage'])->name('articles.affichage');
        Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.detail');

    });
    Route::get('/examens/liste', [ExamenController::class, 'listeexamen'])->name('examens.listeexamen');
    Route::get('/examens/{examen}/liste', [QuestionController::class, 'liste'])->name('examens.questions.liste');
    Route::get('/examens/{examen}/questions/affichage', [QuestionController::class, 'affichage'])->name('question.affichage');
    Route::get('/articles/liste', [ArticleController::class, 'liste'])->name('articles.liste');
    Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.detail');
    Route::get('/articles/{id}', [ArticleController::class, 'show'])->name('articles.show');
    

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/about', [AboutController::class, "index"])->name("about");

Route::get('/', function () {
    return redirect()->route("about");
});

require __DIR__ . '/auth.php';

// Route::post('/resultats', [QuestionsController::class, 'getResultats']);

Route::get('/calculator', function () {
    return Inertia::render('Miraths/NewCalcule'); // Vérifiez si ça pointe vers "NewCalcule"
});
Route::get('/liste-heritier', function () {
    return Inertia::render('Miraths/ListeHeritier'); // Vérifiez si ça pointe vers "NewCalcule"
});
Route::post('/cas-heritier', [MirathController::class, 'calculateMirath'])->name('cas-heritier.calculateMirath');
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

Route::post('/mirath/calcul', [MirathController::class, 'calcul']);

Route::get('/mirath/calcul', function () {
    return Inertia::render('Miraths/CalculMirath');
});

Route::get('/cas-heritier', [MirathController::class, 'showPageCasHeritier']);
Route::post('/mirath/calculate', [MirathController::class, 'calculateMirath']);

Route::get('/results', [MirathController::class, 'showResults'])->name('results');
Route::get('/results', function () {
    return Inertia::render('Miraths/Results');
})->name('results');


// Reçoit le POST du calcul
Route::post('/mirath/calculate', [MirathController::class, 'calculateMirath']);

// Affiche les résultats
Route::get('/results', [MirathController::class, 'showResults'])->name('results');

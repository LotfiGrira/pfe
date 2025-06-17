<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\MirathController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ListeHeritierController;
use App\Http\Controllers\ExamenController;
use App\Http\Controllers\ArticleController;

/**
 * ------------------------
 * Public Routes
 * ------------------------
 */
Route::get('/', fn () => redirect()->route('about'));
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/articles/liste', [ArticleController::class, 'liste'])->name('articles.liste');
Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.detail');

Route::get('/examens/liste', [ExamenController::class, 'listeexamen'])->name('examens.listeexamen');
Route::get('/examens/{examen}/liste', [QuestionController::class, 'liste'])->name('examens.questions.liste');
Route::get('/examens/{examen}/questions/affichage', [QuestionController::class, 'affichage'])->name('question.affichage');

Route::inertia('/calculator', 'Miraths/NewCalcule');
Route::inertia('/liste-heritier', 'Miraths/ListeHeritier');
Route::inertia('/Monasa5atHeritier', 'Miraths/Monasa5atHeritier')->name('monasa5at.heritier');
Route::inertia('/HamelHeritier', 'Miraths/HamelHeritier')->name('hamel.heritier');
Route::inertia('/WasiyaHeritier', 'Miraths/WasiyaHeritier')->name('wasiya.heritier');
Route::inertia('/MafgodHeritier', 'Miraths/MafgodHeritier')->name('mafgod.heritier');
Route::inertia('/GatelHeritier', 'Miraths/GatelHeritier')->name('gatel.heritier');
Route::inertia('/KaferHeritier', 'Miraths/KaferHeritier')->name('kafer.heritier');
Route::inertia('/tagsim-heritier', 'Miraths/TagsimHeritier')->name('tagsim-heritier');
Route::inertia('/liste-monasa5at', 'Miraths/ListeMonasa5at');

Route::get('/listeheritier', [ListeHeritierController::class, 'index'])->name('listeheritier');
Route::get('/mirath/calcul', fn () => Inertia::render('Miraths/CalculMirath'));
Route::get('/cas-heritier', [MirathController::class, 'showPageCasHeritier']);
Route::post('/cas-heritier', [MirathController::class, 'calculateMirath'])->name('cas-heritier.calculateMirath');
Route::post('/mirath/calcul', [MirathController::class, 'calcul']);
Route::post('/mirath/calculate', [MirathController::class, 'calculateMirath']);
Route::get('/results', [MirathController::class, 'showResults'])->name('results');

/**
 * ------------------------
 * Authenticated Routes
 * ------------------------
 */
Route::middleware(['auth'])->group(function () {

    Route::middleware(['verified'])->group(function () {
        Route::get('/dashboard', fn () => Inertia::render('Dashboard'))->name('dashboard');
    });

    /**
     * Admin Routes
     */
    Route::middleware(['role:admin'])->group(function () {
        // Examens
        Route::resource('examens', ExamenController::class)->except(['show']);

        // Questions
        Route::get('/examens/{examen}/questions', [QuestionController::class, 'index'])->name('examens.questions.index');
        Route::get('/examens/{examen}/questions/create', [QuestionController::class, 'create'])->name('questions.create');
        Route::post('/examens/{examen}/questions', [QuestionController::class, 'store'])->name('examens.questions.store');
        Route::get('/examens/{examen}/questions/{id}/edit', [QuestionController::class, 'edit'])->name('questions.edit');
        Route::put('/examens/{examen}/questions/{id}', [QuestionController::class, 'update'])->name('questions.update');
        Route::delete('/examens/{examen}/questions/{id}', [QuestionController::class, 'destroy'])->name('examens.questions.destroy');

        // Articles
        Route::get('/article/create', [ArticleController::class, 'create'])->name('articles.create');
        Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
        Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
        Route::get('/articles/{id}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
        Route::put('/articles/{id}', [ArticleController::class, 'update'])->name('articles.update');
        Route::delete('/articles/{id}', [ArticleController::class, 'destroy'])->name('articles.destroy');
    });

    /**
     * User Routes
     */
    Route::middleware(['role:user'])->group(function () {
        Route::get('/examens/affichage', [ExamenController::class, 'affichage'])->name('examens.affichage');
        Route::get('/examens/{id}', [ExamenController::class, 'show'])->name('examens.show');
        Route::get('/examens/{examen}/questions/{id}', [QuestionController::class, 'show'])->name('question.show');
        Route::get('/articles/{id}', [ArticleController::class, 'show'])->name('articles.show');
        Route::get('/articles/affichage', [ArticleController::class, 'affichage'])->name('articles.affichage');
    });

    // Shared authenticated routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

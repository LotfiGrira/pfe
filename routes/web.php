<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AboutController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ExerciceController;


Route::get('/', function () {
    return redirect()->route("about");
});
Route::get('/exercice', function () {
    return redirect()->route("about");
});
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/about', [AboutController::class, "index"])->name("about");
Route::get('/exercice', [ExerciceController::class,"store"])->name("exercice");
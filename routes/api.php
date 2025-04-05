<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::get('/api/exercice/{id}', [ExerciceController::class, 'showJson']);
Route::post('/resultats', [ExerciceController::class, 'getResultats']);

Route::get('/calcul-mirath', [MirathController::class, 'calculerMirath']);


Route::post('/calculate-mirath', [MirathController::class, 'calculateMirath']);

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::get('/question/{id}', [QuestionController::class, 'showJson']);
Route::post('/resultats', [QuestionController::class, 'getResultats']);

Route::get('/calcul-mirath', [MirathController::class, 'calculerMirath']);


Route::post('/calculate-mirath', [MirathController::class, 'calculateMirath']);

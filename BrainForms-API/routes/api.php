<?php

use Illuminate\Http\Request;

use App\Http\Controllers\AlunoController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MathResponseController; 
use App\Http\Controllers\FisResponseController;

Route::post('/alunos/cadastrar', [AlunoController::class, 'store']);
Route::post('alunos/login', [AuthController::class, 'login']);

// Rotas protegidas
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/perfil', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [AuthController::class, 'logout']);

     // Rotas de matemática (se existirem)
    Route::post('/math-responses', [MathResponseController::class, 'store']);
    
    // ← ROTA PARA FÍSICA (adicione aqui se não existir)
    Route::post('/fis-responses', [FisResponseController::class, 'store']);
});

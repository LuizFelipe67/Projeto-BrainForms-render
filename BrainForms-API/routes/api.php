<?php

use Illuminate\Http\Request;

use App\Http\Controllers\AlunoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConquistaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MathResponseController; 
use App\Http\Controllers\FisResponseController;
use App\Models\Aluno;
use App\Models\Conquista;

Route::post('/alunos/cadastrar', [AlunoController::class, 'store']);
Route::post('alunos/login', [AuthController::class, 'login']);

// Rotas protegidas
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/perfil', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [AuthController::class, 'logout']);

     // Rotas de matemática 
    Route::post('/math-responses', [MathResponseController::class, 'store']);
    
    // ← ROTA PARA FÍSICA 
    Route::post('/fis-responses', [FisResponseController::class, 'store']);
    });


    Route::middleware('auth:sanctum')->get('/alunos/conquistas', [ConquistaController::class, 'listar']);



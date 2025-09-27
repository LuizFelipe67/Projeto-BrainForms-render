<?php

use Illuminate\Http\Request;

use App\Http\Controllers\AlunoController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/alunos/cadastrar', [AlunoController::class, 'store']);

Route::post('alunos/login', [AuthController::class, 'login']);

// Rotas protegidas
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/perfil', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [AuthController::class, 'logout']);
});
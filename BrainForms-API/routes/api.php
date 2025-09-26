<?php

use Illuminate\Http\Request;

use App\Http\Controllers\AlunoController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/alunos/cadastrar', [AlunoController::class, 'store']);
Route::post('/alunos/login', [AuthController::class, 'login']);

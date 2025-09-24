<?php

use App\Http\Controllers\AlunoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/alunos/cadastrar', [AlunoController::class, 'store']);


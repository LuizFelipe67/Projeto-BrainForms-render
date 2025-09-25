<?php

use Illuminate\Http\Request;

use App\Http\Controllers\AlunoController;
use Illuminate\Support\Facades\Route;

Route::post('/alunos/cadastrar', [AlunoController::class, 'store']);

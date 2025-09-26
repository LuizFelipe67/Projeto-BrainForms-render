<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // ou Aluno, se for o seu model

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // 1. Validação dos dados
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // 2. Buscar usuário
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 401,
                'message' => 'Credenciais inválidas'
            ], 401);
        }

        // 3. Se quiser usar token simples
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'status' => 200,
            'message' => 'Login realizado com sucesso',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email
            ]
        ]);
    }
}

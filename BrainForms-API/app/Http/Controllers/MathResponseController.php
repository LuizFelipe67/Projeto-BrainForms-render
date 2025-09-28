<?php

namespace App\Http\Controllers;

use App\Models\MathResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class MathResponseController extends Controller
{
    /**
     * Salva uma resposta de questionário (chamado a cada "próxima questão").
     */
    public function store(Request $request): JsonResponse
    {
        // Validação dos dados de entrada
        $validator = Validator::make($request->all(), [
            'section' => 'required|in:equacao,geometria,trigonometria',
            'question_number' => 'required|integer|min:1',
            'selected_answer' => 'required|string|max:255',
            'question_text' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors()
            ], 422);
        }

        // Pega o aluno autenticado (via token Sanctum, como no seu login)
        $aluno = Auth::user();
        if (!$aluno) {
            return response()->json([
                'status' => 401,
                'message' => 'Usuário não autenticado.'
            ], 401);
        }

        // Verifica se já existe resposta para essa questão (atualiza se sim, para evitar duplicatas)
        $existingResponse = MathResponse::where('aluno_id', $aluno->id)
            ->where('section', $request->section)
            ->where('question_number', $request->question_number)
            ->first();

        $data = [
            'aluno_id' => $aluno->id,
            'section' => $request->section,
            'question_number' => $request->question_number,
            'question_text' => $request->question_text,
            'selected_answer' => $request->selected_answer,
            'is_correct' => $this->verificarRespostaCorreta($request), // ← Aqui chama o método que você vai inserir
        ];

        if ($existingResponse) {
            $existingResponse->update($data);
            $response = $existingResponse->fresh();
        } else {
            $response = MathResponse::create($data);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Resposta salva com sucesso!',
            'response' => $response
        ]);
    }

    // Método auxiliar: Verifica se a resposta está correta (personalize com sua lógica)
    // ← AQUI É ONDE VOCÊ COLOCA O CÓDIGO QUE ME MANDOU!
    private function verificarRespostaCorreta($request): bool
    {
        // Mapeamento completo de respostas corretas por seção e número
        $respostasCorretas = [
            'equacao' => [1 => '4', 2 => '4', 3 => '7', 4 => '2'], // De equação
            'geometria' => [1 => '16 cm²', 2 => '15 cm²', 3 => '20 cm', 4 => '28,26 cm²'], // De geometria
            'trigonometria' => [1 => '0,5', 2 => '0,5', 3 => '1', 4 => '90°'], // Novo: de trigonometria
        ];
        $secao = $request->section;
        $numQuestao = $request->question_number;
        $respostaSelecionada = $request->selected_answer;

        return isset($respostasCorretas[$secao][$numQuestao]) && 
               $respostasCorretas[$secao][$numQuestao] === $respostaSelecionada;
    }
}

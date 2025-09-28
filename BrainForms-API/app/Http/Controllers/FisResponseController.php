<?php

namespace App\Http\Controllers;

use App\Models\FisResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class FisResponseController extends Controller
{
    /**
     * Salva uma resposta de questionário de Física (chamado a cada "próxima questão").
     */
    public function store(Request $request): JsonResponse
    {
        // Validação dos dados de entrada (com todas as seções de Física)
        $validator = Validator::make($request->all(), [
            'section' => 'required|in:fisica,mecanica,eletromagnetismo,termodinamcia,inercia,temperatura,velocidade',
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

        // Pega o aluno autenticado (via token Sanctum)
        $aluno = Auth::user();
        if (!$aluno) {
            return response()->json([
                'status' => 401,
                'message' => 'Usuário não autenticado.'
            ], 401);
        }

        // Verifica se já existe resposta para essa questão (atualiza se sim, para evitar duplicatas)
        $existingResponse = FisResponse::where('aluno_id', $aluno->id)
            ->where('section', $request->section)
            ->where('question_number', $request->question_number)
            ->first();

        $data = [
            'aluno_id' => $aluno->id,
            'section' => $request->section,
            'question_number' => $request->question_number,
            'question_text' => $request->question_text,
            'selected_answer' => $request->selected_answer,
            'is_correct' => $this->verificarRespostaCorreta($request),
        ];

        if ($existingResponse) {
            $existingResponse->update($data);
            $response = $existingResponse->fresh();
        } else {
            $response = FisResponse::create($data);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Resposta salva com sucesso!',
            'response' => $response
        ]);
    }

    // Método auxiliar: Verifica se a resposta está correta
    private function verificarRespostaCorreta($request): bool
    {
        $respostasCorretas = [
            'inercia' => [
                1 => 'Um corpo permanece em repouso ou movimento uniforme, a menos que uma força atue sobre ele.',
                2 => 'Ele continua em movimento retilíneo e uniforme.',
                3 => 'Um carro freando bruscamente e os passageiros sendo projetados para frente.',
                4 => 'Uma força resultante'
            ],
            'temperatura' => [
                1 => '32 °F',
                2 => '373,15 K',
                3 => '25 °C',
                4 => 'K = C + 273,15'
            ],
            'velocidade' => [
                1 => '60 km/h',
                2 => '3 horas',
                3 => '60 km/h',
                4 => '15 km/h'
            ],
            // Adicione mais seções aqui no futuro
        ];
        $secao = $request->section;
        $numQuestao = $request->question_number;
        $respostaSelecionada = $request->selected_answer;

        return isset($respostasCorretas[$secao][$numQuestao]) && 
               $respostasCorretas[$secao][$numQuestao] === $respostaSelecionada;
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aluno;
use App\Models\Conquista;

class ConquistaController extends Controller
{
    public function listar(Request $request)
    {
        $aluno = $request->user(); // pega o aluno autenticado

        $conquistas = Conquista::all();

        $concluidasIds = $aluno->conquistas()->pluck('conquista_id')->toArray();

        $resultado = $conquistas->map(function($c) use ($concluidasIds) {
            return [
                'id' => $c->id,
                'name' => $c->name,
                'cor' => $c->cor,
                'descricao' => $c->descricao,
                'icone' => $c->icone,
                'concluida' => in_array($c->id, $concluidasIds),
            ];
        });

        return response()->json($resultado);
    }

}
//teste
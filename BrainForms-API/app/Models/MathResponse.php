<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MathResponse extends Model
{
    protected $table = 'math_responses';

    protected $fillable = [
        'aluno_id',
        'section',
        'question_number',
        'question_text',
        'selected_answer',
        'is_correct',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
    ];

    // Relacionamento: Uma resposta pertence a um Aluno (muitos-para-um)
    public function aluno()
    {
        return $this->belongsTo(Aluno::class);
    }
}

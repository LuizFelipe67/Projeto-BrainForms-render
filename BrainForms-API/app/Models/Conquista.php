<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conquista extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'cor',
        'descricao', 
        'icone'

    ];

    public function alunos()
    {
        return $this->belongsToMany(Aluno::class, 'aluno_conquistas')
                    ->withPivot('data_conquista')
                    ->withTimestamps();
    }
}

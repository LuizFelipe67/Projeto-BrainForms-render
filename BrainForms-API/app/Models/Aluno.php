<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Aluno extends Model
{
    use HasApiTokens;

    protected $table = 'alunos';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    public function conquistas()
    {
        return $this->belongsToMany(Conquista::class, 'aluno_conquistas')
                    ->withPivot('data_conquista')
                    ->withTimestamps();
    }

}

 

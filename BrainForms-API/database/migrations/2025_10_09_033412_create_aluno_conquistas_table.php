<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('aluno_conquistas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('aluno_id');
            $table->unsignedBigInteger('conquista_id');
            $table->timestamp('data_conquista')->useCurrent();
            $table->timestamps();

            $table->foreign('aluno_id')->references('id')->on('alunos')->onDelete('cascade');
            $table->foreign('conquista_id')->references('id')->on('conquistas')->onDelete('cascade');

            // Evita que o mesmo aluno desbloqueie a mesma conquista mais de uma vez
            $table->unique(['aluno_id', 'conquista_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aluno_conquistas');
    }
};

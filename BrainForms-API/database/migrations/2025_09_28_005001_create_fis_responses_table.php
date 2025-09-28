<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('fis_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aluno_id')->constrained('alunos')->onDelete('cascade'); // Chave estrangeira para tabela alunos
            $table->string('section'); // Ex: 'mecanica', 'eletromagnetismo', 'fisica' (ajuste conforme suas seções)
            $table->integer('question_number'); // Número da questão (ex: 1, 2, etc.)
            $table->text('question_text')->nullable(); // Texto da questão, se dinâmico
            $table->string('selected_answer'); // Resposta selecionada (ex: 'A', 'B' ou texto completo)
            $table->boolean('is_correct')->default(false); // Opcional: se a resposta está correta (para pontuação)
            $table->timestamps(); // created_at e updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fis_responses');
    }
};
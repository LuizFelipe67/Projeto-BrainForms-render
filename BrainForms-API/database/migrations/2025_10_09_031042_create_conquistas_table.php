<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('conquistas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('cor')->nullable();
            $table->text('descricao')->nullable();
            $table->string('icone')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conquistas');
    }
};

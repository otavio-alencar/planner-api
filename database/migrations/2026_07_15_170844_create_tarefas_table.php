<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tarefas', function (Blueprint $table) {
            $table->id();
            $table->foreingId('usuario_id')->constrained('usuarios')->cascadeOnDelete();
            $table->foreignId('categoria_id')->nullable()->constrained('categorias')->nullOnDelete();
            $table->string('descricao');
            $table->enum('status', ['CUMPRIDA', 'PARCIAL', 'NAO_CUMPRIDA'])->default('NAO_CUMPRIDA');
            $table->date('data');
            $table->time('hora_inicio');
            $table->time('hora_fim');
            $table->enum('turno', ['MANHA', 'TARDE', 'NOITE']);
            $table->enum('prioridade', ['ALTA', 'MEDIA', 'BAIXA']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tarefas');
    }
};

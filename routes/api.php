<?php

use App\Http\Controllers\Api\CategoriaController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\LembreteController;
use App\Http\Controllers\Api\MetaController;
use App\Http\Controllers\Api\RelatorioController;
use App\Http\Controllers\Api\TarefaController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/registrar', [AuthController::class, 'registrar']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/perfil', [AuthController::class, 'meuPerfil']);

    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Categorias
    Route::apiResource('categorias', CategoriaController::class);

    // Lembretes
    Route::prefix('lembretes')->group(function () {
        Route::get('/proximos', [LembreteController::class, 'proximos']);
        Route::get('/ativos', [LembreteController::class, 'ativos']);
        Route::get('/recorrentes', [LembreteController::class, 'recorrentes']);
        Route::get('/data/{data}', [LembreteController::class, 'buscarPorData']);
        Route::get('/usuario/{id}', [LembreteController::class, 'buscarPorUsuario']);
    });
    Route::apiResource('lembretes', LembreteController::class);

    // Metas
    Route::prefix('metas')->group(function () {
        Route::get('/status/{status}', [MetaController::class, 'buscarPorStatus']);
        Route::get('/categoria/{id}', [MetaController::class, 'buscarPorCategoria']);
        Route::get('/periodo/{periodo}', [MetaController::class, 'buscarPorPeriodo']);
        Route::get('/usuario/{id}', [MetaController::class, 'buscarPorUsuario']);
    });
    Route::apiResource('metas', MetaController::class);

    // Tarefas
    Route::prefix('tarefas')->group(function () {
        Route::get('/status/{status}', [TarefaController::class, 'buscarPorStatus']);
        Route::get('/categoria/{id}', [TarefaController::class, 'buscarPorCategoria']);
        Route::get('/prioridade/{prioridade}', [TarefaController::class, 'buscarPorPrioridade']);
        Route::get('/data/{data}', [TarefaController::class, 'buscarPorData']);
        Route::get('/turno/{turno}', [TarefaController::class, 'buscarPorTurno']);
        Route::get('/usuario/{id}', [TarefaController::class, 'buscarPorUsuario']);
    });
    Route::apiResource('tarefas', TarefaController::class);

    // Relatórios
    Route::prefix('relatorios')->group(function () {
        Route::get('/metas', [RelatorioController::class, 'metas']);
        Route::get('/tarefas', [RelatorioController::class, 'tarefas']);
        Route::get('/categorias/metas', [RelatorioController::class, 'categorias_metas']);
        Route::get('/categorias/tarefas', [RelatorioController::class, 'categorias_tarefas']);
        Route::get('/produtivo/semana', [RelatorioController::class, 'semana_produtiva']);
        Route::get('/produtivo/mes', [RelatorioController::class, 'mes_produtivo']);
        Route::get('/produtivo/turno', [RelatorioController::class, 'turno_produtivo']);
    });
});
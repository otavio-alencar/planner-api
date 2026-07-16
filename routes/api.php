<?php

use App\Http\Controllers\Api\TarefaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\CategoriaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LembreteController;

Route::post('/registrar', [AuthController::class, 'registrar']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/perfil', [AuthController::class, 'meuPerfil']);

    Route::get('/lembretes/proximos', [LembreteController::class, 'proximos']);

    Route::apiResource('tarefas', TarefaController::class);
});
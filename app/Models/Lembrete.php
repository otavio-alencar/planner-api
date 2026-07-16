<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lembrete extends Model
{
    use HasFactory;

    protected $table = 'lembretes';

    protected $fillable = [
        'usuario_id',
        'categoria_id',
        'descricao',
        'data_hora',
        'recorrente',
        'frequencia',
        'ativo',
    ];

    protected $casts = [
        'data_hora' => 'datetime',
        'recorrente' => 'boolean',
        'ativo' => 'boolean',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}

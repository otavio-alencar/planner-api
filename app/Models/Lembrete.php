<?php

namespace App\Models;

use Carbon\Carbon;
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

    public function proximaOcorrencia(?Carbon $referencia = null): ?Carbon
    {
        if (!$this->recorrente || !$this->frequencia) {
            return $this->data_hora;
        }

        $referencia = $referencia ?? now();
        $proxima = $this->data_hora->copy();

        while ($proxima->lt($referencia)) {
            switch ($this->frequencia) {
                case 'DIARIA':
                    $proxima->addDay();
                    break;

                case 'SEMANAL':
                    $proxima->addWeek();
                    break;

                case 'MENSAL':
                    $proxima->addMonthNoOverflow();
                    break;

                case 'ANUAL':
                    $proxima->addYearNoOverflow();
                    break;

                default:
                    return null;
            }
        }

        return $proxima;
    }
}
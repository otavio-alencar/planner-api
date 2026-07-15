<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meta extends Model
{
    use HasFactory;

    protected $table = 'metas';

    protected $fillable = [
        'usuario_id',
        'descricao',
        'status',
        'periodo',
        'data_inicio',
        'data_fim',
    ];
    

}

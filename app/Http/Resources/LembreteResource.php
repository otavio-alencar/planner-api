<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LembreteResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'descricao' => $this->descricao,
            'data_hora' => $this->data_hora?->format('Y-m-d H:i:s'),
            'recorrente' => $this->recorrente,
            'frequencia' => $this->frequencia,
            'ativo' => $this->ativo,
            'categoria' => $this->whenLoaded('categoria', function () {
                if (!$this->categoria) {
                    return null;
                }

                return [
                    'id' => $this->categoria->id,
                    'nome' => $this->categoria->nome,
                    'cor' => $this->categoria->cor,
                ];
            }),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
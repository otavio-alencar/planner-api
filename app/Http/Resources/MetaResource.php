<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MetaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'descricao' => $this->descricao,
            'status' => $this->status,
            'periodo' => $this->periodo,
            'data_inicio' => $this->data_inicio?->format('Y-m-d'),
            'data_fim' => $this->data_fim?->format('Y-m-d'),
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
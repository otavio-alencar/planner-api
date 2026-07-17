<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMetaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'categoria_id' => [
                'nullable',
                'integer',
                'exists:categorias,id',
            ],
            'descricao' => [
                'required',
                'string',
                'max:255',
            ],
            'status' => [
                'required',
                Rule::in([
                    'EM_ANDAMENTO',
                    'CUMPRIDA',
                    'PARCIAL',
                    'NAO_CUMPRIDA',
                ]),
            ],
            'periodo' => [
                'required',
                Rule::in([
                    'SEMANAL',
                    'MENSAL',
                    'ANUAL',
                ]),
            ],
            'data_inicio' => [
                'required',
                'date_format:Y-m-d',
            ],
            'data_fim' => [
                'required',
                'date_format:Y-m-d',
                'after_or_equal:data_inicio',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'categoria_id.integer' => 'O identificador da categoria deve ser um número inteiro.',
            'categoria_id.exists' => 'A categoria informada não existe.',
            'descricao.required' => 'A descrição é obrigatória.',
            'descricao.string' => 'A descrição deve ser um texto.',
            'descricao.max' => 'A descrição deve possuir no máximo 255 caracteres.',
            'status.required' => 'O status é obrigatório.',
            'status.in' => 'O status informado é inválido.',
            'periodo.required' => 'O período é obrigatório.',
            'periodo.in' => 'O período informado é inválido.',
            'data_inicio.required' => 'A data inicial é obrigatória.',
            'data_inicio.date_format' => 'A data inicial deve usar o formato AAAA-MM-DD.',
            'data_fim.required' => 'A data final é obrigatória.',
            'data_fim.date_format' => 'A data final deve usar o formato AAAA-MM-DD.',
            'data_fim.after_or_equal' => 'A data final deve ser igual ou posterior à data inicial.',
        ];
    }
}
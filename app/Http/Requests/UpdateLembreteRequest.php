<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLembreteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'categoria_id' => [
                'sometimes',
                'nullable',
                'integer',
                'exists:categorias,id',
            ],
            'descricao' => [
                'sometimes',
                'string',
                'max:255',
            ],
            'data_hora' => [
                'sometimes',
                'date_format:Y-m-d H:i:s',
            ],
            'recorrente' => [
                'sometimes',
                'boolean',
            ],
            'frequencia' => [
                'nullable',
                Rule::in([
                    'DIARIA',
                    'SEMANAL',
                    'MENSAL',
                    'ANUAL',
                ]),
                'required_if:recorrente,true',
                'prohibited_unless:recorrente,true',
            ],
            'ativo' => [
                'sometimes',
                'boolean',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'categoria_id.integer' => 'O identificador da categoria deve ser um número inteiro.',
            'categoria_id.exists' => 'A categoria informada não existe.',
            'descricao.string' => 'A descrição deve ser um texto.',
            'descricao.max' => 'A descrição deve possuir no máximo 255 caracteres.',
            'data_hora.date_format' => 'A data e hora devem usar o formato AAAA-MM-DD HH:MM:SS.',
            'recorrente.boolean' => 'O campo recorrente deve ser verdadeiro ou falso.',
            'frequencia.in' => 'A frequência informada é inválida.',
            'frequencia.required_if' => 'A frequência é obrigatória para lembretes recorrentes.',
            'ativo.boolean' => 'O campo ativo deve ser verdadeiro ou falso.',
        ];
    }
}

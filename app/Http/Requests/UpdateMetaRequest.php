<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

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
            'status' => [
                'sometimes',
                Rule::in([
                    'EM_ANDAMENTO',
                    'CUMPRIDA',
                    'PARCIAL',
                    'NAO_CUMPRIDA',
                ]),
            ],
            'periodo' => [
                'sometimes',
                Rule::in([
                    'SEMANAL',
                    'MENSAL',
                    'ANUAL',
                ]),
            ],
            'data_inicio' => [
                'sometimes',
                'date_format:Y-m-d',
            ],
            'data_fim' => [
                'sometimes',
                'date_format:Y-m-d',
            ],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            if ($validator->errors()->isNotEmpty()) {
                return;
            }

            if (
                !$this->has('data_inicio')
                && !$this->has('data_fim')
            ) {
                return;
            }

            $meta = $this->user()
                ->metas()
                ->find($this->route('meta'));

            if (!$meta) {
                return;
            }

            $dataInicio = $this->input(
                'data_inicio',
                $meta->data_inicio?->format('Y-m-d')
            );

            $dataFim = $this->input(
                'data_fim',
                $meta->data_fim?->format('Y-m-d')
            );

            if ($dataInicio && $dataFim && $dataFim < $dataInicio) {
                $validator->errors()->add(
                    'data_fim',
                    'A data final deve ser igual ou posterior à data inicial.'
                );
            }
        });
    }

    public function messages(): array
    {
        return [
            'categoria_id.integer' => 'O identificador da categoria deve ser um número inteiro.',
            'categoria_id.exists' => 'A categoria informada não existe.',
            'descricao.string' => 'A descrição deve ser um texto.',
            'descricao.max' => 'A descrição deve possuir no máximo 255 caracteres.',
            'status.in' => 'O status informado é inválido.',
            'periodo.in' => 'O período informado é inválido.',
            'data_inicio.date_format' => 'A data inicial deve usar o formato AAAA-MM-DD.',
            'data_fim.date_format' => 'A data final deve usar o formato AAAA-MM-DD.',
        ];
    }
}
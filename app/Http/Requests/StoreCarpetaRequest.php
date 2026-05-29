<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCarpetaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('carpetas.crear') ?? false;
    }

    public function rules(): array
    {
        return [
            'semestre_id' => ['required', 'exists:semestres,id'],
            'parent_id' => ['nullable', 'exists:carpetas,id'],
            'nombre' => [
                'required',
                'string',
                'max:255',
                Rule::unique('carpetas')->where(fn ($query) => $query
                    ->where('semestre_id', $this->input('semestre_id'))
                    ->where('parent_id', $this->input('parent_id'))),
            ],
            'descripcion' => ['nullable', 'string'],
        ];
    }
}

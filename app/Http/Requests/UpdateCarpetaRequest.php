<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCarpetaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('carpetas.editar') ?? false;
    }

    public function rules(): array
    {
        $carpeta = $this->route('carpeta');

        return [
            'semestre_id' => ['required', 'exists:semestres,id'],
            'parent_id' => ['nullable', 'exists:carpetas,id', Rule::notIn([$carpeta?->id])],
            'nombre' => [
                'required',
                'string',
                'max:255',
                Rule::unique('carpetas')->ignore($carpeta?->id)->where(fn ($query) => $query
                    ->where('semestre_id', $this->input('semestre_id'))
                    ->where('parent_id', $this->input('parent_id'))),
            ],
            'descripcion' => ['nullable', 'string'],
        ];
    }
}

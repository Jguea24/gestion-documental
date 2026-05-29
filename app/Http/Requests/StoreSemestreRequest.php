<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSemestreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('semestres.crear') ?? false;
    }

    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:255'],
            'anio' => ['required', 'integer', 'min:2000', 'max:2100'],
            'fecha_inicio' => ['nullable', 'date'],
            'fecha_fin' => ['nullable', 'date', 'after_or_equal:fecha_inicio'],
            'activo' => ['nullable', 'boolean'],
        ];
    }
}

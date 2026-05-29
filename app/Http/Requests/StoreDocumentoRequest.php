<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDocumentoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('documentos.crear') ?? false;
    }

    public function rules(): array
    {
        return [
            'semestre_id' => ['required', 'exists:semestres,id'],
            'carpeta_id' => ['required', 'exists:carpetas,id'],
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'archivo' => ['required', 'file', 'max:20480', 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png,zip,rar'],
        ];
    }
}

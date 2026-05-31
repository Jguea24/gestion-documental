<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('documents.rename') ?? false;
    }

    public function rules(): array
    {
        return [
            'original_name' => ['required', 'string', 'max:255'],
        ];
    }
}

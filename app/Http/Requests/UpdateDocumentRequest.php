<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        $document = $this->route('document');

        return $document && ($this->user()?->can('update', $document) ?? false);
    }

    public function rules(): array
    {
        return [
            'original_name' => ['required', 'string', 'max:255'],
        ];
    }
}

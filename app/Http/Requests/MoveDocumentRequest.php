<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MoveDocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('documents.move') ?? false;
    }

    public function rules(): array
    {
        return [
            'folder_id' => ['required', 'exists:folders,id'],
        ];
    }
}

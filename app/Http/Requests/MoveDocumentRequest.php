<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MoveDocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        $document = $this->route('document');
        $user = $this->user();

        return $document
            && ($user?->can('move', $document) ?? false)
            && $user->canAccessFolder($this->integer('folder_id'));
    }

    public function rules(): array
    {
        return [
            'folder_id' => ['required', 'exists:folders,id'],
        ];
    }
}

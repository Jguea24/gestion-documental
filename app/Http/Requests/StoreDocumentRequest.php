<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->user();

        return ($user?->can('documents.upload') ?? false)
            && $user->canAccessFolder($this->integer('folder_id'));
    }

    public function rules(): array
    {
        return [
            'folder_id' => ['required', 'exists:folders,id'],
            'files' => ['required', 'array', 'min:1'],
            'files.*' => ['file', 'max:51200', 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png,gif,webp,zip,rar,txt,csv'],
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MoveFolderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('folders.move') ?? false;
    }

    public function rules(): array
    {
        $folder = $this->route('folder');

        return [
            'parent_id' => ['nullable', 'exists:folders,id', Rule::notIn([$folder?->id])],
        ];
    }
}

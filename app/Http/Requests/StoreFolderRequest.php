<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreFolderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('folders.create') ?? false;
    }

    public function rules(): array
    {
        return [
            'parent_id' => ['nullable', 'exists:folders,id'],
            'name' => [
                'required',
                'string',
                'max:120',
                Rule::unique('folders')->where(fn ($query) => $query
                    ->where('parent_id', $this->input('parent_id'))
                    ->whereNull('deleted_at')),
            ],
            'description' => ['nullable', 'string', 'max:1000'],
        ];
    }
}

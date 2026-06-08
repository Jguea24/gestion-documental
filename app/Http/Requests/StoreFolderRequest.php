<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreFolderRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->user();

        if (! ($user?->can('folders.create') ?? false)) {
            return false;
        }

        return ! $this->filled('parent_id') || $user->canAccessFolder($this->integer('parent_id'));
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

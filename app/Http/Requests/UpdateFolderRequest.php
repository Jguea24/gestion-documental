<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateFolderRequest extends FormRequest
{
    public function authorize(): bool
    {
        $folder = $this->route('folder');

        return $folder && ($this->user()?->can('update', $folder) ?? false);
    }

    public function rules(): array
    {
        $folder = $this->route('folder');

        return [
            'name' => [
                'required',
                'string',
                'max:120',
                Rule::unique('folders')
                    ->ignore($folder?->id)
                    ->where(fn ($query) => $query
                        ->where('parent_id', $folder?->parent_id)
                        ->whereNull('deleted_at')),
            ],
            'description' => ['nullable', 'string', 'max:1000'],
        ];
    }
}

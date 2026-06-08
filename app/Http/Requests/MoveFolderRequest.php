<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MoveFolderRequest extends FormRequest
{
    public function authorize(): bool
    {
        $folder = $this->route('folder');
        $user = $this->user();

        return $folder
            && ($user?->can('move', $folder) ?? false)
            && (! $this->filled('parent_id') || $user->canAccessFolder($this->integer('parent_id')));
    }

    public function rules(): array
    {
        $folder = $this->route('folder');

        return [
            'parent_id' => ['nullable', 'exists:folders,id', Rule::notIn([$folder?->id])],
        ];
    }
}

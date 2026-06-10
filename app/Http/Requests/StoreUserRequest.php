<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('users.create') ?? false;
    }

    protected function prepareForValidation(): void
    {
        if (! $this->filled('email') && $this->filled('name')) {
            $this->merge([
                'email' => $this->generatedInstitutionalEmail($this->string('name')->toString()),
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'ends_with:.wini@gmail.com', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'roles' => ['array'],
            'roles.*' => ['exists:roles,name'],
            'permissions' => ['array'],
            'permissions.*' => ['exists:permissions,name'],
            'folder_permissions' => ['array'],
            'folder_permissions.*' => ['exists:folders,id'],
        ];
    }

    private function generatedInstitutionalEmail(string $name): string
    {
        $slug = Str::of($name)
            ->ascii()
            ->lower()
            ->replaceMatches('/[^a-z0-9]+/', '.')
            ->trim('.')
            ->toString();

        return ($slug ?: 'usuario').'.wini@gmail.com';
    }
}

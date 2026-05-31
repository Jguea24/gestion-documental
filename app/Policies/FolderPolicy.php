<?php

namespace App\Policies;

use App\Models\Folder;
use App\Models\User;

class FolderPolicy
{
    public function view(User $user, Folder $folder): bool
    {
        return $user->can('explorer.view');
    }

    public function create(User $user): bool
    {
        return $user->can('folders.create');
    }

    public function update(User $user, Folder $folder): bool
    {
        return $user->hasRole('Administrador')
            || ($user->can('folders.rename') && $folder->created_by === $user->id);
    }

    public function delete(User $user, Folder $folder): bool
    {
        return $user->hasRole('Administrador')
            || ($user->can('folders.delete') && $folder->created_by === $user->id);
    }
}

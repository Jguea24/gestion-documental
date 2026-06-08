<?php

namespace App\Policies;

use App\Models\Document;
use App\Models\User;

class DocumentPolicy
{
    public function view(User $user, Document $document): bool
    {
        return $user->can('documents.preview')
            && $user->canAccessFolder($document->folder_id);
    }

    public function download(User $user, Document $document): bool
    {
        return $user->can('documents.download')
            && $user->canAccessFolder($document->folder_id);
    }

    public function update(User $user, Document $document): bool
    {
        return $user->hasRole('Administrador')
            || ($user->can('documents.rename') && $document->user_id === $user->id);
    }

    public function move(User $user, Document $document): bool
    {
        return $user->hasRole('Administrador')
            || ($user->can('documents.move') && $document->user_id === $user->id);
    }

    public function delete(User $user, Document $document): bool
    {
        return $user->hasRole('Administrador')
            || ($user->can('documents.delete') && $document->user_id === $user->id);
    }

    public function restore(User $user, Document $document): bool
    {
        return $user->hasRole('Administrador')
            || ($user->can('documents.restore') && $document->user_id === $user->id);
    }
}

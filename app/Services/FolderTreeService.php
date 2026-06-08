<?php

namespace App\Services;

use App\Models\Folder;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class FolderTreeService
{
    public function roots(?User $user = null): Collection
    {
        if ($user?->hasRestrictedFolderAccess()) {
            return $this->restrictedRoots($user);
        }

        return Folder::query()
            ->whereNull('parent_id')
            ->with('recursiveChildren')
            ->ordered()
            ->get();
    }

    private function restrictedRoots(User $user): Collection
    {
        $allowedIds = $user->accessibleFolderIds();

        if ($allowedIds->isEmpty()) {
            return new Collection();
        }

        $folders = Folder::query()
            ->whereIn('id', $allowedIds)
            ->ordered()
            ->get();

        $grouped = $folders->groupBy('parent_id');

        $build = function ($parentId) use (&$build, $grouped): Collection {
            return new Collection(
                ($grouped->get($parentId) ?? collect())
                    ->map(function (Folder $folder) use ($build) {
                        $folder->setRelation('recursiveChildren', $build($folder->id));

                        return $folder;
                    })
                    ->values()
            );
        };

        $rootFolders = $folders
            ->filter(fn (Folder $folder) => $folder->parent_id === null || ! $allowedIds->contains($folder->parent_id))
            ->values();

        return new Collection(
            $rootFolders
                ->map(function (Folder $folder) use ($build) {
                    $folder->setRelation('recursiveChildren', $build($folder->id));

                    return $folder;
                })
                ->values()
        );
    }
}

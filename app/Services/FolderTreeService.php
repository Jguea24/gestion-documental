<?php

namespace App\Services;

use App\Models\Folder;
use Illuminate\Database\Eloquent\Collection;

class FolderTreeService
{
    public function roots(): Collection
    {
        return Folder::query()
            ->whereNull('parent_id')
            ->with('recursiveChildren')
            ->orderBy('name')
            ->get();
    }
}

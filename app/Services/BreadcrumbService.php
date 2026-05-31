<?php

namespace App\Services;

use App\Models\Folder;
use Illuminate\Support\Collection;

class BreadcrumbService
{
    public function for(?Folder $folder): Collection
    {
        $items = collect();

        while ($folder) {
            $items->prepend($folder);
            $folder = $folder->parent;
        }

        return $items;
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\MoveFolderRequest;
use App\Http\Requests\StoreFolderRequest;
use App\Http\Requests\UpdateFolderRequest;
use App\Models\Folder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;

class FolderController extends Controller
{
    public function store(StoreFolderRequest $request): RedirectResponse
    {
        Folder::create($request->validated() + ['created_by' => $request->user()->id]);

        return back()->with('success', 'Carpeta creada correctamente.');
    }

    public function update(UpdateFolderRequest $request, Folder $folder): RedirectResponse
    {
        $folder->update($request->validated());

        return back()->with('success', 'Carpeta renombrada correctamente.');
    }

    public function move(MoveFolderRequest $request, Folder $folder): RedirectResponse
    {
        $parentId = $request->input('parent_id');

        abort_if($parentId && $this->isDescendant((int) $parentId, $folder), 422, 'No se puede mover una carpeta dentro de si misma.');

        $folder->update(['parent_id' => $parentId]);

        return redirect()->route('explorer.index', ['folder' => $parentId ?: $folder->id])
            ->with('success', 'Carpeta movida correctamente.');
    }

    public function destroy(Folder $folder): RedirectResponse
    {
        Gate::authorize('delete', $folder);

        $folder->delete();

        return redirect()->route('explorer.index', ['folder' => $folder->parent_id])
            ->with('success', 'Carpeta enviada a la papelera.');
    }

    public function restore(int $folder): RedirectResponse
    {
        $folder = Folder::withTrashed()->findOrFail($folder);

        Gate::authorize('restore', $folder);
        $folder->restore();

        return back()->with('success', 'Carpeta restaurada correctamente.');
    }

    public function forceDelete(int $folder): RedirectResponse
    {
        $folder = Folder::onlyTrashed()->findOrFail($folder);

        Gate::authorize('delete', $folder);
        $folder->forceDelete();

        return back()->with('success', 'Carpeta eliminada definitivamente.');
    }

    private function isDescendant(int $parentId, Folder $folder): bool
    {
        $parent = Folder::find($parentId);

        while ($parent) {
            if ($parent->id === $folder->id) {
                return true;
            }

            $parent = $parent->parent;
        }

        return false;
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Folder;
use App\Models\User;
use App\Services\BreadcrumbService;
use App\Services\FolderTreeService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExplorerController extends Controller
{
    public function index(Request $request, BreadcrumbService $breadcrumbs, FolderTreeService $tree): View
    {
        abort_unless($request->user()?->can('explorer.view'), 403);

        $user = $request->user();
        $accessibleFolderIds = $user->hasRestrictedFolderAccess()
            ? $user->accessibleFolderIds()
            : null;

        if ($request->filled('folder')) {
            $folder = Folder::with('parent')->findOrFail($request->integer('folder'));
            abort_if($accessibleFolderIds !== null && ! $accessibleFolderIds->contains($folder->id), 403);
        } else {
            $folderQuery = Folder::whereNull('parent_id')->ordered();

            if ($accessibleFolderIds !== null) {
                $folderQuery->whereIn('id', $accessibleFolderIds);
            }

            $folder = $folderQuery->first();

            if (! $folder && $accessibleFolderIds !== null && $accessibleFolderIds->isNotEmpty()) {
                $folder = Folder::whereIn('id', $accessibleFolderIds)->ordered()->first();
            }
        }

        $foldersQuery = Folder::with('creator')->withCount(['children', 'documents']);
        $documentsQuery = Document::with('user', 'folder');

        if ($accessibleFolderIds !== null) {
            $foldersQuery->whereIn('id', $accessibleFolderIds);
            $documentsQuery->whereIn('folder_id', $accessibleFolderIds);
        }

        if ($request->filled('q')) {
            $search = $request->string('q')->toString();
            $foldersQuery->where('name', 'like', "%{$search}%");
            $documentsQuery->where('original_name', 'like', "%{$search}%");
        } else {
            $foldersQuery->where('parent_id', $folder?->id);
            $documentsQuery->where('folder_id', $folder?->id);
        }

        $semester = $request->string('semester')->toString();
        $subject = $request->string('subject')->toString();

        if ($semester !== '') {
            $documentsQuery->whereHas('folder', fn ($query) => $query->where('name', 'like', "%{$semester}%"));
        }

        if ($subject !== '') {
            $documentsQuery->whereHas('folder', fn ($query) => $query->where('name', 'like', "%{$subject}%"));
        }

        if ($request->filled('user_id')) {
            $documentsQuery->where('user_id', $request->integer('user_id'));
        }

        $breadcrumbItems = $breadcrumbs->for($folder?->loadMissing('parent'));

        if ($accessibleFolderIds !== null) {
            $breadcrumbItems = $breadcrumbItems->filter(fn (Folder $crumb) => $accessibleFolderIds->contains($crumb->id))->values();
        }

        return view('explorer.index', [
            'currentFolder' => $folder,
            'breadcrumbs' => $breadcrumbItems,
            'sidebarFolders' => $tree->roots($user),
            'folders' => $foldersQuery->ordered()->get(),
            'documents' => $documentsQuery->orderBy('original_name')->get(),
            'allFolders' => $accessibleFolderIds === null
                ? Folder::ordered()->get()
                : Folder::whereIn('id', $accessibleFolderIds)->ordered()->get(),
            'users' => User::orderBy('name')->get(),
            'filters' => $request->only(['q', 'semester', 'subject', 'user_id']),
        ]);
    }
}

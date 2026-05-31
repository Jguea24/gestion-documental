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

        $folder = $request->filled('folder')
            ? Folder::with('parent')->findOrFail($request->integer('folder'))
            : Folder::whereNull('parent_id')->orderBy('name')->first();

        $foldersQuery = Folder::with('creator')->withCount(['children', 'documents']);
        $documentsQuery = Document::with('user', 'folder');

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

        return view('explorer.index', [
            'currentFolder' => $folder,
            'breadcrumbs' => $breadcrumbs->for($folder?->loadMissing('parent')),
            'sidebarFolders' => $tree->roots(),
            'folders' => $foldersQuery->orderBy('name')->get(),
            'documents' => $documentsQuery->orderBy('original_name')->get(),
            'allFolders' => Folder::orderBy('name')->get(),
            'users' => User::orderBy('name')->get(),
            'filters' => $request->only(['q', 'semester', 'subject', 'user_id']),
        ]);
    }
}

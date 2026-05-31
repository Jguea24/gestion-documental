<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TrashController extends Controller
{
    public function __invoke(Request $request): View
    {
        abort_unless($request->user()?->can('trash.view'), 403);

        return view('trash.index', [
            'folders' => Folder::onlyTrashed()->with('creator')->latest('deleted_at')->get(),
            'documents' => Document::onlyTrashed()->with(['folder', 'user'])->latest('deleted_at')->get(),
        ]);
    }
}

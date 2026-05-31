<?php

namespace App\Http\Controllers;

use App\Http\Requests\MoveDocumentRequest;
use App\Http\Requests\StoreDocumentRequest;
use App\Http\Requests\UpdateDocumentRequest;
use App\Models\Document;
use App\Models\Folder;
use App\Services\DocumentStorageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DocumentController extends Controller
{
    public function store(StoreDocumentRequest $request, DocumentStorageService $storage): RedirectResponse
    {
        $folder = Folder::findOrFail($request->integer('folder_id'));

        foreach ($request->file('files', []) as $file) {
            $storage->store($file, $folder, $request->user()->id);
        }

        return redirect()->route('explorer.index', ['folder' => $folder->id])
            ->with('success', 'Archivo(s) cargado(s) correctamente.');
    }

    public function update(UpdateDocumentRequest $request, Document $document): RedirectResponse
    {
        $document->update($request->validated());

        return back()->with('success', 'Archivo renombrado correctamente.');
    }

    public function move(MoveDocumentRequest $request, Document $document): RedirectResponse
    {
        $document->update(['folder_id' => $request->integer('folder_id')]);

        return redirect()->route('explorer.index', ['folder' => $document->folder_id])
            ->with('success', 'Archivo movido correctamente.');
    }

    public function download(Document $document): StreamedResponse
    {
        abort_unless(auth()->user()?->can('documents.download'), 403);

        return Storage::disk('public')->download(
            $document->path,
            $document->original_name.'.'.$document->extension
        );
    }

    public function preview(Document $document): View
    {
        abort_unless(auth()->user()?->can('documents.preview'), 403);

        return view('documents.preview', compact('document'));
    }

    public function destroy(Document $document): RedirectResponse
    {
        abort_unless(auth()->user()?->can('documents.delete'), 403);

        $folderId = $document->folder_id;
        $document->delete();

        return redirect()->route('explorer.index', ['folder' => $folderId])
            ->with('success', 'Archivo enviado a la papelera.');
    }

    public function restore(int $document): RedirectResponse
    {
        abort_unless(auth()->user()?->can('documents.restore'), 403);

        Document::withTrashed()->findOrFail($document)->restore();

        return back()->with('success', 'Archivo restaurado correctamente.');
    }

    public function forceDelete(int $document): RedirectResponse
    {
        abort_unless(auth()->user()?->can('documents.delete'), 403);

        $document = Document::onlyTrashed()->findOrFail($document);
        Storage::disk('public')->delete($document->path);
        $document->forceDelete();

        return back()->with('success', 'Archivo eliminado definitivamente.');
    }
}

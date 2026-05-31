<?php

namespace App\Services;

use App\Models\Document;
use App\Models\Folder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentStorageService
{
    public function store(UploadedFile $file, Folder $folder, int $userId): Document
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $fileName = Str::uuid().'.'.$extension;
        $path = $file->storeAs('documents/'.$folder->id, $fileName, 'public');

        return Document::create([
            'folder_id' => $folder->id,
            'user_id' => $userId,
            'file_name' => $fileName,
            'original_name' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
            'extension' => $extension,
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'path' => $path,
        ]);
    }

    public function deleteFile(Document $document): void
    {
        Storage::disk('public')->delete($document->path);
    }
}

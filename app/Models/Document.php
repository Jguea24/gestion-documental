<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'folder_id',
        'user_id',
        'file_name',
        'original_name',
        'extension',
        'mime_type',
        'size',
        'path',
    ];

    public function folder(): BelongsTo
    {
        return $this->belongsTo(Folder::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isPdf(): bool
    {
        return $this->extension === 'pdf';
    }

    public function isImage(): bool
    {
        return str_starts_with($this->mime_type, 'image/');
    }

    public function isPreviewable(): bool
    {
        return $this->isPdf() || $this->isImage();
    }

    public function isOfficeDocument(): bool
    {
        return in_array($this->extension, ['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'], true);
    }
}

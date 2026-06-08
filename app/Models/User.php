<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, HasRoles, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_photo_path',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function folders(): HasMany
    {
        return $this->hasMany(Folder::class, 'created_by');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function permittedFolders(): BelongsToMany
    {
        return $this->belongsToMany(Folder::class, 'folder_user_access')->withTimestamps();
    }

    public function hasRestrictedFolderAccess(): bool
    {
        return $this->hasRole('Estudiante') && ! $this->hasRole('Administrador');
    }

    public function homeRouteName(): string
    {
        return $this->hasRestrictedFolderAccess() ? 'explorer.index' : 'dashboard';
    }

    public function accessibleFolderIds(): Collection
    {
        if (! $this->hasRestrictedFolderAccess()) {
            return Folder::query()->pluck('id');
        }

        $allowedIds = $this->permittedFolders()->pluck('folders.id')->unique()->values();
        $allIds = collect($allowedIds);

        while ($allowedIds->isNotEmpty()) {
            $allowedIds = Folder::query()
                ->whereIn('parent_id', $allowedIds)
                ->pluck('id')
                ->diff($allIds)
                ->values();

            $allIds = $allIds->merge($allowedIds)->unique()->values();
        }

        return $allIds;
    }

    public function canAccessFolder(?int $folderId): bool
    {
        if (! $folderId) {
            return ! $this->hasRestrictedFolderAccess();
        }

        if (! $this->hasRestrictedFolderAccess()) {
            return true;
        }

        return $this->accessibleFolderIds()->contains($folderId);
    }

    public function getProfilePhotoUrlAttribute(): string
    {
        return $this->profile_photo_path
            ? Storage::disk('public')->url($this->profile_photo_path)
            : asset('images/johnny.png');
    }
}

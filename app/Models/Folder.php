<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Folder extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'parent_id',
        'name',
        'description',
        'created_by',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->ordered();
    }

    public function recursiveChildren(): HasMany
    {
        return $this->children()->with('recursiveChildren');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class)->orderBy('original_name');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function permittedUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'folder_user_access')->withTimestamps();
    }

    public function getRouteKeyName(): string
    {
        return 'id';
    }

    public function scopeOrdered($query)
    {
        return $query
            ->orderByRaw("
                CASE
                    WHEN UPPER(name) LIKE '%PRIMER%SEMESTRE%' THEN 1
                    WHEN UPPER(name) LIKE '%SEGUNDO%SEMESTRE%' THEN 2
                    WHEN UPPER(name) LIKE '%TERCER%SEMESTRE%' THEN 3
                    WHEN UPPER(name) LIKE '%CUARTO%SEMESTRE%' THEN 4
                    WHEN UPPER(name) LIKE '%QUINTO%SEMESTRE%' THEN 5
                    WHEN UPPER(name) LIKE '%SEXTO%SEMESTRE%' THEN 6
                    WHEN UPPER(name) LIKE '%SEPTIMO%SEMESTRE%' OR UPPER(name) LIKE '%S%PTIMO%SEMESTRE%' THEN 7
                    WHEN UPPER(name) LIKE '%OCTAVO%SEMESTRE%' THEN 8
                    WHEN UPPER(name) LIKE '%NOVENO%SEMESTRE%' THEN 9
                    WHEN UPPER(name) LIKE '%DECIMO%SEMESTRE%' OR UPPER(name) LIKE '%D%CIMO%SEMESTRE%' THEN 10
                    WHEN UPPER(name) LIKE '10%SEMESTRE%' OR UPPER(name) LIKE '% 10%SEMESTRE%' OR UPPER(name) LIKE '%-10%SEMESTRE%' THEN 10
                    WHEN UPPER(name) LIKE '1%SEMESTRE%' OR UPPER(name) LIKE '% 1%SEMESTRE%' OR UPPER(name) LIKE '%-1%SEMESTRE%' THEN 1
                    WHEN UPPER(name) LIKE '2%SEMESTRE%' OR UPPER(name) LIKE '% 2%SEMESTRE%' OR UPPER(name) LIKE '%-2%SEMESTRE%' THEN 2
                    WHEN UPPER(name) LIKE '3%SEMESTRE%' OR UPPER(name) LIKE '% 3%SEMESTRE%' OR UPPER(name) LIKE '%-3%SEMESTRE%' THEN 3
                    WHEN UPPER(name) LIKE '4%SEMESTRE%' OR UPPER(name) LIKE '% 4%SEMESTRE%' OR UPPER(name) LIKE '%-4%SEMESTRE%' THEN 4
                    WHEN UPPER(name) LIKE '5%SEMESTRE%' OR UPPER(name) LIKE '% 5%SEMESTRE%' OR UPPER(name) LIKE '%-5%SEMESTRE%' THEN 5
                    WHEN UPPER(name) LIKE '6%SEMESTRE%' OR UPPER(name) LIKE '% 6%SEMESTRE%' OR UPPER(name) LIKE '%-6%SEMESTRE%' THEN 6
                    WHEN UPPER(name) LIKE '7%SEMESTRE%' OR UPPER(name) LIKE '% 7%SEMESTRE%' OR UPPER(name) LIKE '%-7%SEMESTRE%' THEN 7
                    WHEN UPPER(name) LIKE '8%SEMESTRE%' OR UPPER(name) LIKE '% 8%SEMESTRE%' OR UPPER(name) LIKE '%-8%SEMESTRE%' THEN 8
                    WHEN UPPER(name) LIKE '9%SEMESTRE%' OR UPPER(name) LIKE '% 9%SEMESTRE%' OR UPPER(name) LIKE '%-9%SEMESTRE%' THEN 9
                    ELSE 999
                END
            ")
            ->orderBy('name');
    }
}

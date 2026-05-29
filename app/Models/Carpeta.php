<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Carpeta extends Model
{
    use HasFactory;

    protected $fillable = [
        'semestre_id',
        'parent_id',
        'nombre',
        'descripcion',
    ];

    public function semestre(): BelongsTo
    {
        return $this->belongsTo(Semestre::class);
    }

    public function padre(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function subcarpetas(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->with('subcarpetas');
    }

    public function documentos(): HasMany
    {
        return $this->hasMany(Documento::class);
    }
}

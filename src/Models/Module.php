<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Module extends Model
{
    protected $fillable = [
        'title', 'code', 'description', 'credits', 'image', 'leader_id',
    ];

    protected $casts = [
        'credits' => 'integer',
    ];

    public function leader(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'leader_id');
    }

    public function programmeModules(): HasMany
    {
        return $this->hasMany(ProgrammeModule::class);
    }

    public function programmes()
    {
        return $this->hasManyThrough(
            Programme::class,
            ProgrammeModule::class,
            'module_id',
            'id',
            'id',
            'programme_id'
        );
    }

    public function scopeSearch($query, string $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('title', 'LIKE', "%{$term}%")
              ->orWhere('code', 'LIKE', "%{$term}%");
        });
    }
}

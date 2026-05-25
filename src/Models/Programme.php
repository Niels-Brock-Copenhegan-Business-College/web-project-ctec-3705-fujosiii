<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Programme extends Model
{
    protected $fillable = [
        'title', 'slug', 'level', 'description', 'duration_years',
        'ucas_code', 'image', 'is_published', 'leader_id',
    ];

    protected $casts = [
        'is_published'   => 'boolean',
        'duration_years' => 'integer',
    ];

    // ── Relationships ────────────────────────────────────────────────────────

    public function leader(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'leader_id');
    }

    public function programmeModules(): HasMany
    {
        return $this->hasMany(ProgrammeModule::class)->orderBy('year')->orderBy('sort_order');
    }

    public function interests(): HasMany
    {
        return $this->hasMany(Interest::class);
    }

    // ── Scopes ───────────────────────────────────────────────────────────────

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeLevel($query, string $level)
    {
        return $query->where('level', $level);
    }

    public function scopeSearch($query, string $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('title', 'LIKE', "%{$term}%")
              ->orWhere('description', 'LIKE', "%{$term}%")
              ->orWhere('ucas_code', 'LIKE', "%{$term}%");
        });
    }
}

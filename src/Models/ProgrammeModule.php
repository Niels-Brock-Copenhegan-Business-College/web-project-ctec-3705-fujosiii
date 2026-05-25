<?php
// This file is part of PHP CS Fixer.
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProgrammeModule extends Model
{
    protected $table = 'programme_modules';

    protected $fillable = [
        'programme_id', 'module_id', 'year', 'sort_order',
    ];

    protected $casts = [
        'year'       => 'integer',
        'sort_order' => 'integer',
    ];

    public function programme(): BelongsTo
    {
        return $this->belongsTo(Programme::class);
    }

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }
}

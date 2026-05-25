<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Staff extends Model
{
    protected $table = 'staff';

    protected $fillable = [
        'name', 'email', 'title', 'bio', 'photo',
    ];

    public function ledProgrammes(): HasMany
    {
        return $this->hasMany(Programme::class, 'leader_id');
    }

    public function ledModules(): HasMany
    {
        return $this->hasMany(Module::class, 'leader_id');
    }
}

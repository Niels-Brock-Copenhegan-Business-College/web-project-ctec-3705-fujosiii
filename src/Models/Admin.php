<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admins';

    protected $fillable = [
        'name', 'email', 'password', 'role',
    ];

    protected $hidden = ['password'];

    public function verifyPassword(string $plain): bool
    {
        return password_verify($plain, $this->password);
    }
}

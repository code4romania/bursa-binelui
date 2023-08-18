<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class BadgeUser extends Pivot
{
    public $incrementing = true;

    protected $casts = [
        'allocated_at' => 'datetime',
    ];

    public static function booted(): void
    {
        static::creating(function (self $badgeUser) {
            $badgeUser->allocated_at = now();
        });
    }
}

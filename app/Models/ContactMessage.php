<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = [
        'name',
        'email',
        'message',
        'mark_as_read',
    ];

    protected $casts = [
        'mark_as_read' => 'boolean',
    ];
}

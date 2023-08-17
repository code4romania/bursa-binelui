<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'closed_at',
        'user_id',
        'subject',
        'content',
    ];

    protected $casts = [
        'closed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(TicketMessage::class);
    }

    public function scopeWhereOpen(Builder $query): Builder
    {
        return $query->whereNull('closed_at');
    }

    public function scopeWhereClosed(Builder $query): Builder
    {
        return $query->whereNotNull('closed_at');
    }

    public function isOpen(): bool
    {
        return \is_null($this->closed_at);
    }

    public function open(): void
    {
        $this->update([
            'closed_at' => null,
        ]);
    }

    public function close(): void
    {
        $this->update([
            'closed_at' => $this->freshTimestamp(),
        ]);
    }
}

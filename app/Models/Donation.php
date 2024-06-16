<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\HasUuid;
use App\Enums\EuPlatescStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Donation extends Model
{
    use HasFactory;
    use HasUuid;

    protected $fillable = [
        'uuid',
        'user_id',
        'organization_id',
        'project_id',
        'amount',
        'charge_amount',
        'first_name',
        'last_name',
        'email',
        'status',
        'card_status',
        'card_holder_status_message',
        'approval_date',
        'charge_date',
        'updated_without_correct_e_pid',
        'ep_id',
    ];

    protected $casts = [
        'status' => EuPlatescStatus::class,
        'updated_without_correct_e_pid' => 'boolean',
        'approval_date' => 'datetime',
        'charge_date' => 'datetime',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function scopeSearch(Builder $query, string $searchedText): Builder
    {
        return $query
            ->orWhere('first_name', 'LIKE', "%{$searchedText}%")
            ->orWhere('last_name', 'LIKE', "%{$searchedText}%")
            ->orWhere('email', 'LIKE', "%{$searchedText}%");
    }

    public function scopeWhereCharged(Builder $query): Builder
    {
        return $query->where('status', EuPlatescStatus::CHARGED);
    }

    public function scopeWherePending(Builder $query): Builder
    {
        return $query->whereIn('status', [
            EuPlatescStatus::INITIALIZE,
            EuPlatescStatus::AUTHORIZED,
        ]);
    }

    public function scopeWhereFailed(Builder $query): Builder
    {
        return $query->whereIn('status', [
            EuPlatescStatus::UNAUTHORIZED,
            EuPlatescStatus::CANCELED,
            EuPlatescStatus::ABORTED,
            EuPlatescStatus::PAYMENT_DECLINED,
            EuPlatescStatus::POSSIBLE_FRAUD,
        ]);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function championshipStage(): BelongsTo
    {
        return $this->belongsTo(ChampionshipStage::class);
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}

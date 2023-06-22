<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Donation extends Model
{
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
    ];
    use HasFactory;

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

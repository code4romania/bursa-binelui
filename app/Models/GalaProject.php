<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\BelongsToOrganization;
use App\Concerns\HasCounties;
use App\Traits\HasProjectStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class GalaProject extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use BelongsToOrganization;
    use HasCounties;
    use InteractsWithMedia;
    use HasProjectStatus;
    use LogsActivity;

    protected $fillable = [
        'edition_id',
        'gala_id',
        'title',
        'description',
        'start_date',
        'end_date',
        'categories',
        'youth',
        'organization_type',
        'reason',
        'solution',
        'project_details',
        'special',
        'results',
        'proud',
        'partnership',
        'partnership_details',
        'budget_details',
        'area',
        'participants',
        'team_details',
        'contact_name',
        'contact_position',
        'contact_phone_number',
        'contact_email',
        'status',
        'eligible',
        'short_list',
    ];

    protected $with = [
        'gala',
        'edition',
    ];

    public function gala(): BelongsTo
    {
        return $this->belongsTo(Gala::class);
    }

    public function edition(): BelongsTo
    {
        return $this->belongsTo(Edition::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->dontSubmitEmptyLogs()
            ->logFillable()
            ->logOnlyDirty();
    }

    public function markAsEligible(): bool
    {
        return $this->update(['eligible' => 1]);
    }

    public function markAsIneligible(): bool
    {
        return $this->update(['eligible' => 0]);
    }

    public function addToShortList(): bool
    {
        return $this->update(['short_list' => 1]);
    }

    public function removeFromShortList(): bool
    {
        return $this->update(['short_list' => 0]);
    }
}

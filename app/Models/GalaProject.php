<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\BelongsToOrganization;
use App\Concerns\HasCounties;
use App\Concerns\HasSlug;
use App\Traits\HasProjectStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Znck\Eloquent\Relations\BelongsToThrough;
use Znck\Eloquent\Traits\BelongsToThrough as BelongsToThroughTrait;

class GalaProject extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use HasSlug;
    use BelongsToOrganization;
    use HasCounties;
    use InteractsWithMedia;
    use HasProjectStatus;
    use LogsActivity;
    use BelongsToThroughTrait;

    protected $fillable = [
        'gala_id',
        'name',
        'description',
        'start_date',
        'end_date',
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
        'contact',
        'status',
        'eligible',
        'short_list',
    ];

    protected $with = [
        'gala',
        'categories',
        'counties',
        'organization',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'youth' => 'boolean',
        'partnership' => 'boolean',
        'eligible' => 'boolean',
        'short_list' => 'boolean',
        'contact' => 'array',
    ];

    public string $slugFieldSource = 'name';

    public function gala(): BelongsTo
    {
        return $this->belongsTo(Gala::class);
    }

    public function edition(): BelongsToThrough
    {
        return $this->belongsToThrough(Edition::class, Gala::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(EditionCategories::class, 'edition_categories_gala_project');
    }

    public function prizes(): BelongsToMany
    {
        return $this->belongsToMany(Prize::class);
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
        return $this->update(['eligible' => true]);
    }

    public function markAsIneligible(): bool
    {
        return $this->update(['eligible' => false]);
    }

    public function addToShortList(): bool
    {
        return $this->update(['short_list' => true]);
    }

    public function removeFromShortList(): bool
    {
        return $this->update(['short_list' => 0]);
    }
}

<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\BelongsToOrganization;
use App\Concerns\HasCounties;
use App\Traits\HasProjectStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class RegionalProject extends Model implements HasMedia
{
    use HasFactory;
    use BelongsToOrganization;
    use HasCounties;
    use InteractsWithMedia;
    use HasProjectStatus;
    use LogsActivity;

    protected $fillable = [
        'name',
        'organization_id',
        'slug',
        'description',
        'start_date',
        'end_date',
        'for_youth',
        'identified_need',
        'proposed_solution',
        'project_progress',
        'project_differentiator',
        'key_results',
        'pride_success',
        'had_partners',
        'partners',
        'project_budget',
        'impact_area',
        'participant_count',
        'project_team',
        'info_sources',
        'contact_info',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date:Y-m-d',
        'end_date' => 'date:Y-m-d',
        'for_youth' => 'boolean',
        'had_partners' => 'boolean',
        'contact_info' => 'array',
    ];

    protected $appends = ['cover_image', 'type'];

    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->fit(Manipulations::FIT_CROP, 300, 300);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(ProjectCategory::class, 'regional_project_category');
    }

    public function getCoverImageAttribute(): string
    {
        return $this->getFirstMediaUrl('regionalProjectFiles', 'preview') ?? '';
    }

    public function getTypeAttribute(): string
    {
        return 'regional';
    }

    public function getRequiredFieldsForApproval(): array
    {
        return [
            'name',
            'description',
            'start_date',
            'end_date',
            'for_youth',
            'identified_need',
            'proposed_solution',
            'project_progress',
            'project_differentiator',
            'key_results',
            'pride_success',
            'had_partners',
            'partners',
            'project_budget',
            'impact_area',
            'participant_count',
            'project_team',
            'info_sources',
            'contact_info',
        ];
    }
}

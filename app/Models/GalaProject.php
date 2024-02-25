<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class GalaProject extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

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
        'edition'
    ];

    public function gala(): BelongsTo
    {
        return $this->belongsTo(Gala::class);
    }

    public function edition(): BelongsTo
    {
        return $this->belongsTo(Edition::class);
    }
}

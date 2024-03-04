<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\BelongsToEdition;
use App\Concerns\HasCounties;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Gala extends Model implements HasMedia
{
    use HasFactory;
    use HasCounties;
    use InteractsWithMedia;
    use BelongsToEdition;

    protected $fillable = [
        'title',
        'edition_id',
        'start_date',
        'end_date',
        'start_sign_up',
        'end_sign_up',
        'start_validate',
        'end_validate',
        'start_evaluation',
        'end_evaluation',
        'start_gale',
        'location',
    ];

    protected $with = ['edition', 'counties'];

    public function galaProject(): HasMany
    {
        return $this->hasMany(GalaProject::class);
    }

    public function getRegistrationIsOpenAttribute(): bool
    {
        return now()->between($this->start_sign_up, $this->end_sign_up);
    }
}

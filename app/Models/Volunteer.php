<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Volunteer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function projects(): MorphToMany
    {
        return $this->morphedByMany(Project::class, 'model', 'model_has_volunteers', 'model_id');
    }

    public function organizations(): MorphToMany
    {
        return $this->morphedByMany(Organization::class, 'model', 'model_has_volunteers', 'model_id');
    }

    public function scope()
    {
    }
}

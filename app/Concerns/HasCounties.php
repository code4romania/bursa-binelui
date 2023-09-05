<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Models\County;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasCounties
{
    public function counties(): MorphToMany
    {
        return $this->morphToMany(County::class, 'model', 'model_has_counties', 'model_id');
    }
}

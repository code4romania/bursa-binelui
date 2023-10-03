<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Models\Organization;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToOrganization
{
    public function initializeBelongsToOrganization(): void
    {
        $this->fillable[] = 'organization_id';
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function belongsToOrganization(?Organization $organization = null): bool
    {
        if ($organization === null) {
            return $this->organization_id !== null;
        }

        return $this->organization_id === $organization->getKey();
    }

    public function scopeWhereBelongsToOrganization(Builder $query, ?Organization $organization = null): Builder
    {
        if ($organization === null) {
            return $query->whereNotNull('organization_id');
        }

        return $query->whereBelongsTo($organization);
    }
}

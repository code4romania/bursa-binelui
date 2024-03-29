<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Organization;
use Illuminate\Http\UploadedFile;

class OrganizationService
{
    public static function update(Organization $organization, array $attributes)
    {
        $attributes = collect($attributes);

        $key = $attributes->keys()->first();
        $value = $attributes->get($key);

        return match ($key) {
            'counties' => $organization->counties()->sync($value),

            'activity_domains' => $organization->activityDomains()->sync($value),

            'logo' => $organization->addMedia($value)->toMediaCollection('logo'),

            'statute' => static::saveStatue($organization, $value),

            default => \in_array($key, $organization->requiresApproval)
                ? $organization->fill($attributes->all())->saveForApproval()
                : $organization->update($attributes->all()),
        };
    }

    protected static function saveStatue(Organization $organization, UploadedFile $file): void
    {
        $statute = $organization->addMedia($file)
            ->toMediaCollection('statute_pending');

        activity('pending')
            ->event('updated')
            ->performedOn($organization)
            ->withProperties([
                'statute' => [
                    'old' => $organization->getFirstMedia('statute')?->id,
                    'new' => $statute->id,
                ],
            ])
            ->log('statute');
    }
}

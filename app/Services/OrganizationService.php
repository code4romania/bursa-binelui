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

        if (! \in_array($key, $organization->requiresApproval)) {
            $organization->update($attributes->all());

            return;
        }

        return match ($key) {
            'counties' => $organization->counties()
                ->sync(collect($value)->pluck('id')),

            'activity_domains' => $organization->activityDomains()
                ->sync(collect($value)->pluck('id')),

            'logo' => $organization->addMedia($value)
                ->toMediaCollection('logo'),

            'statute' => static::saveStatue($organization, $value),

            default => $organization->fill($attributes->all())->saveForApproval(),
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

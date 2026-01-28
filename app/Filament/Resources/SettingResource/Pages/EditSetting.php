<?php

declare(strict_types=1);

namespace App\Filament\Resources\SettingResource\Pages;

use App\Filament\Resources\SettingResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Validation\ValidationException;

class EditSetting extends EditRecord
{
    protected static string $resource = SettingResource::class;

    protected function getActions(): array
    {
        return [];
    }

    public function getTitle(): string
    {
        $slug = $this->getRecord()->slug;
        $key = "setting.slugs.{$slug}";

        return __($key) !== $key ? __($key) : $slug;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $slug = $this->getRecord()->slug;
        $value = $data['value'] ?? '';

        $numericSlugs = [
            'donation_min_amount',
            'donation_max_amount',
            'project_expiration_notification_days_before',
            'project_expiration_notification_days_before_reminder',
        ];

        if (\in_array($slug, $numericSlugs, true)) {
            if (! is_numeric($value) || (float) $value < 0) {
                throw ValidationException::withMessages([
                    'value' => __('validation.numeric', ['attribute' => __('setting.value')]),
                ]);
            }
        }

        if ($slug === 'contact_email') {
            $validator = \Validator::make(['value' => $value], ['value' => 'required|email']);
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }
        }

        return $data;
    }
}

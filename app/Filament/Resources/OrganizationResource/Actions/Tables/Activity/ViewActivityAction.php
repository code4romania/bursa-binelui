<?php

declare(strict_types=1);

namespace App\Filament\Resources\OrganizationResource\Actions\Tables\Activity;

use App\Filament\Forms\Components\Value;
use App\Models\Activity;
use Filament\Tables\Actions\ViewAction as BaseAction;
use Illuminate\Support\HtmlString;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ViewActivityAction extends BaseAction
{
    public static function getDefaultName(): ?string
    {
        return 'view';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->form([
            Value::make('created_at')
                ->label(__('activity.column.created_at'))
                ->inlineLabel(),

            Value::make('causer.name')
                ->label(__('activity.column.causer'))
                ->inlineLabel(),

            Value::make('changed_field')
                ->label(__('activity.column.changed_field'))
                ->inlineLabel()
                ->content(
                    fn (Activity $record) => __('organization.labels.' . $record->changed_field)
                ),

            Value::make('changed_field_old_value')
                ->label(__('activity.value.old'))
                ->inlineLabel(),

            Value::make('changed_field_new_value')
                ->label(__('activity.value.new'))
                ->content(
                    function (Activity $record) {
                    if ($record->changed_field === 'statute') {
                        $media = Media::find($record->changed_field_new_value);
                        if (! $media) {
                            return '-';
                        }

                        return new HtmlString(
                            sprintf(
                                '<a href="%s" target="_blank">%s</a>',
                                $media->getTemporaryUrl(now()->addMinutes(30)),
                                $media->file_name
                            )
                        );
                    }

                    return $record->changed_field_new_value;
                }
                )
                ->inlineLabel(),
        ]);

        // $this->modalActions([
        // ])
    }
}

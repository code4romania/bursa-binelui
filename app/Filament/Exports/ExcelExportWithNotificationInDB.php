<?php

declare(strict_types=1);

namespace App\Filament\Exports;

use App\Notifications\Admin\ExportExcelNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ExcelExportWithNotificationInDB extends ExcelExport
{
    public function export()
    {
        $this->resolveFilename();
        $this->resolveWriterType();

        if (! $this->isQueued()) {
            return $this->downloadExport($this->getFilename(), $this->getWriterType());
        }

        $this->prepareQueuedExport();

        $filename = Str::uuid() . '-' . $this->getFilename();
        $authUser = auth()->user();

        $this
            ->queueExport($filename, 'filament-excel', $this->getWriterType())
            ->chain([
                function () use ($authUser, $filename) {
                    Notification::send(
                        $authUser,
                        new ExportExcelNotification($authUser, $filename)
                    );
                }]);
    }
}

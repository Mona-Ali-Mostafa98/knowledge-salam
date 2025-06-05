<?php

namespace App\Filament\Exports;

use App\Models\Event;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Collection;

class EventExporter extends Exporter
{
    protected static ?string $model = Event::class;
    protected Collection $events;
    protected static ?string $langFile = 'system';

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label(__(self::$langFile . '.id')),
            ExportColumn::make('title')
                ->label(__(self::$langFile . '.title')),
            ExportColumn::make('country_id')
                ->label(__(self::$langFile . '.country_id')),
            ExportColumn::make('city_id')
                ->label(__(self::$langFile . '.city_id')),
            ExportColumn::make('venue')
                ->label(__(self::$langFile . '.venue')),
            ExportColumn::make('sector_id')
                ->label(__(self::$langFile . '.sector_id')),
            ExportColumn::make('event_date')
                ->label(__(self::$langFile . '.event_date')),
            ExportColumn::make('event_time')
                ->label(__(self::$langFile . '.event_time')),
            ExportColumn::make('details')
                ->label(__(self::$langFile . '.details')),
            ExportColumn::make('event_type')
                ->label(__(self::$langFile . '.event_type')),
            ExportColumn::make('tags')
                ->label(__(self::$langFile . '.tags')),
            ExportColumn::make('saudi_direction')
                ->label(__(self::$langFile . '.saudi_direction')),
            ExportColumn::make('saudi_direction_id')
                ->label(__(self::$langFile . '.saudi_direction_id')),
            ExportColumn::make('url')
                ->label(__(self::$langFile . '.url')),
            ExportColumn::make('approval_status')
                ->label(__(self::$langFile . '.approval_status')),
            ExportColumn::make('event_status')
                ->label(__(self::$langFile . '.event_status')),
            ExportColumn::make('created_by')
                ->label(__(self::$langFile . '.created_by')),
            ExportColumn::make('position_type_id')
                ->label(__(self::$langFile . '.position_type_id')),
            ExportColumn::make('publish_date')
                ->label(__(self::$langFile . '.publish_date')),
            ExportColumn::make('note')
                ->label(__(self::$langFile . '.note')),
            ExportColumn::make('send_to_reviewer')
                ->label(__(self::$langFile . '.send_to_reviewer')),
            ExportColumn::make('reviewed_by')
                ->label(__(self::$langFile . '.reviewed_by')),
            ExportColumn::make('send_to_approval')
                ->label(__(self::$langFile . '.send_to_approval')),
            ExportColumn::make('approved_by')
                ->label(__(self::$langFile . '.approved_by')),
            ExportColumn::make('is_published')
                ->label(__(self::$langFile . '.is_published')),
            ExportColumn::make('expire_date')
                ->label(__(self::$langFile . '.expire_date')),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = __('system.Your event export has completed and ') . number_format($export->successful_rows) . ' ' . __('system.' .str('row')->plural($export->successful_rows)) . __('system.exported');

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}

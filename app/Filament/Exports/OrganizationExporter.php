<?php

namespace App\Filament\Exports;

use App\Models\Organization;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class OrganizationExporter extends Exporter
{
    protected static ?string $model = Organization::class;

    protected static ?string $langFile = 'organization';

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label(__('system.id')),
            ExportColumn::make('name')
                ->label(__(self::$langFile . '.name')),
            ExportColumn::make('foundation_date')
                ->label(__(self::$langFile . '.foundation_date')),
            ExportColumn::make('type_id')
                ->label(__(self::$langFile . '.type_id')),
            ExportColumn::make('logo')
                ->label(__(self::$langFile . '.logo')),
            ExportColumn::make('continent.name')
                ->label(__(self::$langFile . '.continent_id')),
            ExportColumn::make('country.name')
                ->label(__(self::$langFile . '.country_id')),
            ExportColumn::make('boss')
                ->label(__(self::$langFile . '.boss')),
            ExportColumn::make('details')
                ->label(__(self::$langFile . '.details')),
            ExportColumn::make('website')
                ->label(__(self::$langFile . '.website')),
            ExportColumn::make('added_reason')
                ->label(__(self::$langFile . '.added_reason')),
            ExportColumn::make('status_id')
                ->label(__(self::$langFile . '.organization_status')),
            ExportColumn::make('references')
                ->label(__(self::$langFile . '.references')),
            ExportColumn::make('email')
                ->label(__(self::$langFile . '.email')),
            ExportColumn::make('mobile')
                ->label(__(self::$langFile . '.mobile')),
            ExportColumn::make('organization_level.name')
                ->label(__(self::$langFile . '.organization_level_id')),
            ExportColumn::make('money_resource.name')
                ->label(__(self::$langFile . '.money_resource_id')),
            ExportColumn::make('city.name')
                ->label(__(self::$langFile . '.city_id')),
            ExportColumn::make('global_influencer')
                ->label(__(self::$langFile . '.global_influencer')),
            ExportColumn::make('saudi_interested')
                ->label(__(self::$langFile . '.saudi_interested')),
            ExportColumn::make('address')
                ->label(__(self::$langFile . '.address')),
            ExportColumn::make('boss_join')
                ->label(__(self::$langFile . '.boss_join')),
            ExportColumn::make('boss_leave')
                ->label(__(self::$langFile . '.boss_leave')),
            ExportColumn::make('resources')
                ->label(__(self::$langFile . '.resources')),
            ExportColumn::make('created_at')
                ->label(__('system.created_at')),
            ExportColumn::make('approval_status')
                ->label(__('system.approval_status')),
            ExportColumn::make('send_to_reviewer')
                ->label(__('system.send_to_reviewer')),
            ExportColumn::make('reviewed_by')
                ->label(__('system.reviewed_by')),
            ExportColumn::make('send_to_approval')
                ->label(__('system.send_to_approval')),
            ExportColumn::make('approved_by')
                ->label(__('system.approved_by')),
            ExportColumn::make('is_published')
                ->label(__('system.is_published')),
            ExportColumn::make('expire_date')
                ->label(__('system.expire_date')),
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

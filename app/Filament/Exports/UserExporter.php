<?php

namespace App\Filament\Exports;

use App\Models\User;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class UserExporter extends Exporter
{
    protected static ?string $model = User::class;
    protected static ?string $langFile = 'system';

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label(__(self::$langFile . '.id')),
            ExportColumn::make('name')
                ->label(__(self::$langFile . '.name')),
            ExportColumn::make('email')
                ->label(__(self::$langFile . '.email')),
            ExportColumn::make('email_verified_at')
                ->label(__(self::$langFile . '.email_verified_at')),
            ExportColumn::make('mobile')
                ->label(__(self::$langFile . '.mobile')),
            ExportColumn::make('job_title')
                ->label(__(self::$langFile . '.job_title')),
            ExportColumn::make('national_id')
                ->label(__(self::$langFile . '.national_id')),
            ExportColumn::make('bio')
                ->label(__(self::$langFile . '.bio')),
            ExportColumn::make('registration_purpose')
                ->label(__(self::$langFile . '.registration_purpose')),
            ExportColumn::make('identity_document')
                ->label(__(self::$langFile . '.identity_document')),
            ExportColumn::make('photo')
                ->label(__(self::$langFile . '.photo')),
            ExportColumn::make('requested_role')
                ->label(__(self::$langFile . '.requested_role')),
            ExportColumn::make('approval_status')
                ->label(__(self::$langFile . '.approval_status')),
            ExportColumn::make('publish_date')
                ->label(__(self::$langFile . '.publish_date')),
            ExportColumn::make('deleted_at')
                ->label(__(self::$langFile . '.created_at')),
            ExportColumn::make('updated_at')
                ->label(__(self::$langFile . '.sector_id')),
            ExportColumn::make('organization.name')
                ->label(__(self::$langFile . '.organization_id')),
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
            ExportColumn::make('last_login_at')
                ->label(__(self::$langFile . '.last_login_at')),
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

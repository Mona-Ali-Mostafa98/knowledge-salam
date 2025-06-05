<?php

namespace App\Filament\Exports;

use App\Models\People;
use App\Models\Person;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class PeopleExporter extends Exporter
{
    protected static ?string $model = Person::class;
    protected static ?string $langFile = 'person';

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')->label(__('system.id')),
            ExportColumn::make('first_name')->label(__('person.first_name')),
            ExportColumn::make('mid_name')->label(__('person.mid_name')),
            ExportColumn::make('last_name')->label(__('person.last_name')),
            ExportColumn::make('bod')->label(__('person.bod')),
            ExportColumn::make('death_date')->label(__('person.death_date')),
            ExportColumn::make('nationality.name')->label(__('person.nationality_id')),
            ExportColumn::make('birth_country.name')->label(__('person.birth_country_id')),
            ExportColumn::make('birth_city.name')->label(__('person.birth_city_id')),
            ExportColumn::make('accommodation')->label(__('person.accommodation')),
            ExportColumn::make('marital_status')->label(__('person.marital_status')),
            ExportColumn::make('partner_name')->label(__('person.partner_name')),
            ExportColumn::make('global_influencer')->label(__('person.global_influencer')),
            ExportColumn::make('fameReason.name')->label(__('person.fame_reasons_id')),
            ExportColumn::make('saudi_interested')->label(__('person.saudi_interested')),
            ExportColumn::make('status')->label(__('person.status')),
            ExportColumn::make('has_issues')->label(__('person.has_issues')),
            ExportColumn::make('issues')->label(__('person.issues')),
            ExportColumn::make('resources')->label(__('person.resources')),
            ExportColumn::make('email')->label(__('person.email')),
            ExportColumn::make('mobile')->label(__('person.mobile')),
            ExportColumn::make('address')->label(__('person.address')),
            ExportColumn::make('religion.name')->label(__('person.religion_id')),
            ExportColumn::make('sect.name')->label(__('person.sect_id')),
            ExportColumn::make('religiosity.name')->label(__('person.religiosity_id')),
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

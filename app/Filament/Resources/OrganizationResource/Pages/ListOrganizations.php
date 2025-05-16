<?php

namespace App\Filament\Resources\OrganizationResource\Pages;

use App\Filament\Resources\OrganizationResource;
use App\Imports\OrganizationImport;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use YOS\FilamentExcel\Actions\Import;

class ListOrganizations extends ListRecords
{
    protected static string $resource = OrganizationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //            Import::make()
            //                ->import(OrganizationImport::class)
            //                ->type(\Maatwebsite\Excel\Excel::XLSX)
            //                ->label('Import from excel')
            //                ->hint('Upload xlsx type')
            //                ->color('success'),
            Actions\CreateAction::make(),
        ];
    }
}

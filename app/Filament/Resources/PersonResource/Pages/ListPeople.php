<?php

namespace App\Filament\Resources\PersonResource\Pages;

use App\Filament\Resources\PersonResource;
use App\Imports\PersonImport;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use YOS\FilamentExcel\Actions\Import;

class ListPeople extends ListRecords
{
    protected static string $resource = PersonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            //            Import::make()
            //                ->import(PersonImport::class)
            //                ->type(\Maatwebsite\Excel\Excel::XLSX)
            //                ->label('Import from excel')
            //                ->hint('Upload xlsx type')
            //                ->color('success'),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

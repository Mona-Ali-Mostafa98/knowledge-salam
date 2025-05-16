<?php

namespace App\Filament\Resources\SaudiArticlesResource\Pages;

use App\Filament\Resources\SaudiArticlesResource;
use App\Imports\ArticleImport;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use YOS\FilamentExcel\Actions\Import;

class ListSaudiArticles extends ListRecords
{
    protected static string $resource = SaudiArticlesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //            Import::make()
            //                ->import(ArticleImport::class)
            //                ->type(\Maatwebsite\Excel\Excel::XLSX)
            //                ->label('Import from excel')
            //                ->hint('Upload xlsx type')
            //                ->color('success'),
            Actions\CreateAction::make(),
        ];
    }
}

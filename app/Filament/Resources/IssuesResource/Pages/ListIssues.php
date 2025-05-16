<?php

namespace App\Filament\Resources\IssuesResource\Pages;

use App\Filament\Resources\IssuesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIssues extends ListRecords
{
    protected static string $resource = IssuesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

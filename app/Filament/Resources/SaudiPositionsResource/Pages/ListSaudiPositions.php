<?php

namespace App\Filament\Resources\SaudiPositionsResource\Pages;

use App\Filament\Resources\SaudiPositionsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSaudiPositions extends ListRecords
{
    protected static string $resource = SaudiPositionsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

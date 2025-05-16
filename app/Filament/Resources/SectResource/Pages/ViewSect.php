<?php

namespace App\Filament\Resources\SectResource\Pages;

use App\Filament\Resources\SectResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSect extends ViewRecord
{
    protected static string $resource = SectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}

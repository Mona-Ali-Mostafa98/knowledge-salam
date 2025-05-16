<?php

namespace App\Filament\Resources\SaudiPositionsResource\Pages;

use App\Filament\Resources\SaudiPositionsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSaudiPositions extends EditRecord
{
    protected static string $resource = SaudiPositionsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

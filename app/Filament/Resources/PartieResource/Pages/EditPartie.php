<?php

namespace App\Filament\Resources\PartieResource\Pages;

use App\Filament\Resources\PartieResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPartie extends EditRecord
{
    protected static string $resource = PartieResource::class;

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

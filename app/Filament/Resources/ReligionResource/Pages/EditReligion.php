<?php

namespace App\Filament\Resources\ReligionResource\Pages;

use App\Filament\Resources\ReligionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReligion extends EditRecord
{
    protected static string $resource = ReligionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
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

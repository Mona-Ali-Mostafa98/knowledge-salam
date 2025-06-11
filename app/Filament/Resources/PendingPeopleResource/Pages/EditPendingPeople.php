<?php

namespace App\Filament\Resources\PendingPeopleResource\Pages;

use App\Filament\Resources\PendingPeopleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPendingPeople extends EditRecord
{
    protected static string $resource = PendingPeopleResource::class;

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

<?php

namespace App\Filament\Resources\ApprovedPeopleResource\Pages;

use App\Filament\Resources\ApprovedPeopleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditApprovedPeople extends EditRecord
{
    protected static string $resource = ApprovedPeopleResource::class;

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

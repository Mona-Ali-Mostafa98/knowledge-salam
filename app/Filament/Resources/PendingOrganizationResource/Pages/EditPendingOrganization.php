<?php

namespace App\Filament\Resources\PendingOrganizationResource\Pages;

use App\Filament\Resources\PendingOrganizationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPendingOrganization extends EditRecord
{
    protected static string $resource = PendingOrganizationResource::class;

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

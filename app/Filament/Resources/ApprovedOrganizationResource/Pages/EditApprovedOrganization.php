<?php

namespace App\Filament\Resources\ApprovedOrganizationResource\Pages;

use App\Filament\Resources\ApprovedOrganizationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditApprovedOrganization extends EditRecord
{
    protected static string $resource = ApprovedOrganizationResource::class;

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
<?php

namespace App\Filament\Resources\ConstantResource\Pages;

use App\Filament\Resources\ConstantResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditConstant extends EditRecord
{
    protected static string $resource = ConstantResource::class;

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

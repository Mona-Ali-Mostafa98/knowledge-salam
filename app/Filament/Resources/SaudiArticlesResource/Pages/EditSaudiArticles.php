<?php

namespace App\Filament\Resources\SaudiArticlesResource\Pages;

use App\Filament\Resources\SaudiArticlesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSaudiArticles extends EditRecord
{
    protected static string $resource = SaudiArticlesResource::class;

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

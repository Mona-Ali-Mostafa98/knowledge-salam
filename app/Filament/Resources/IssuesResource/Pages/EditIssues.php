<?php

namespace App\Filament\Resources\IssuesResource\Pages;

use App\Filament\Resources\IssuesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditIssues extends EditRecord
{
    protected static string $resource = IssuesResource::class;

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

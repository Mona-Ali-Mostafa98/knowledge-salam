<?php

namespace App\Filament\Resources\NationalityResource\Pages;

use App\Filament\Resources\NationalityResource;
use Filament\Resources\Pages\CreateRecord;

class CreateNationality extends CreateRecord
{
    protected static string $resource = NationalityResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

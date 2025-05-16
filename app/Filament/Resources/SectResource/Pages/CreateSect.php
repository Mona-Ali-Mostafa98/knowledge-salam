<?php

namespace App\Filament\Resources\SectResource\Pages;

use App\Filament\Resources\SectResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSect extends CreateRecord
{
    protected static string $resource = SectResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

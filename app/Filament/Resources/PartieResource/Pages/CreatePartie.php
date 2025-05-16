<?php

namespace App\Filament\Resources\PartieResource\Pages;

use App\Filament\Resources\PartieResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePartie extends CreateRecord
{
    protected static string $resource = PartieResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

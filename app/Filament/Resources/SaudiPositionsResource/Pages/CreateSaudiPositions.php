<?php

namespace App\Filament\Resources\SaudiPositionsResource\Pages;

use App\Filament\Resources\SaudiPositionsResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSaudiPositions extends CreateRecord
{
    protected static string $resource = SaudiPositionsResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

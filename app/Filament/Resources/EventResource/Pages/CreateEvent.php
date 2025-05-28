<?php

namespace App\Filament\Resources\EventResource\Pages;

use App\Filament\Resources\EventResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEvent extends CreateRecord
{
    protected static string $resource = EventResource::class;

    public $latitude;
    public $longitude;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

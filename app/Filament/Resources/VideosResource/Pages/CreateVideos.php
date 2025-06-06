<?php

namespace App\Filament\Resources\VideosResource\Pages;

use App\Filament\Resources\VideosResource;
use Filament\Resources\Pages\CreateRecord;

class CreateVideos extends CreateRecord
{
    protected static string $resource = VideosResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

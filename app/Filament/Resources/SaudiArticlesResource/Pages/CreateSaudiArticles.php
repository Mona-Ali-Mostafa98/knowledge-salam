<?php

namespace App\Filament\Resources\SaudiArticlesResource\Pages;

use App\Filament\Resources\SaudiArticlesResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSaudiArticles extends CreateRecord
{
    protected static string $resource = SaudiArticlesResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

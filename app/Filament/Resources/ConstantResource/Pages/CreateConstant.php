<?php

namespace App\Filament\Resources\ConstantResource\Pages;

use App\Filament\Resources\ConstantResource;
use Filament\Resources\Pages\CreateRecord;

class CreateConstant extends CreateRecord
{
    protected static string $resource = ConstantResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

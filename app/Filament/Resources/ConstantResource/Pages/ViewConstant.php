<?php

namespace App\Filament\Resources\ConstantResource\Pages;

use App\Filament\Resources\ConstantResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewConstant extends ViewRecord
{
    protected static string $resource = ConstantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}

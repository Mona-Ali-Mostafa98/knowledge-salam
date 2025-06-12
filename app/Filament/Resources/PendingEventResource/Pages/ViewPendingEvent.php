<?php

namespace App\Filament\Resources\PendingEventResource\Pages;

use App\Filament\Resources\PendingEventResource;
use Filament\Resources\Pages\ViewRecord;

class ViewPendingEvent extends ViewRecord
{
    protected static string $resource = PendingEventResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}

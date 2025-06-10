<?php

namespace App\Filament\Resources\PendingEventResource\Pages;

use App\Filament\Resources\PendingEventResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPendingEvents extends ListRecords
{
    protected static string $resource = PendingEventResource::class;
}

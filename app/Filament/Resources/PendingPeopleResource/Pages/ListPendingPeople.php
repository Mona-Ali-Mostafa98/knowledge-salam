<?php

namespace App\Filament\Resources\PendingPeopleResource\Pages;

use App\Filament\Resources\PendingPeopleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPendingPeople extends ListRecords
{
    protected static string $resource = PendingPeopleResource::class;
}
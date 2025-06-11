<?php

namespace App\Filament\Resources\ApprovedPeopleResource\Pages;

use App\Filament\Resources\ApprovedPeopleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListApprovedPeople extends ListRecords
{
    protected static string $resource = ApprovedPeopleResource::class;
}

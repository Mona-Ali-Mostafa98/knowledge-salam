<?php

namespace App\Filament\Resources\ApprovedPeopleResource\Pages;

use App\Filament\Resources\ApprovedPeopleResource;
use Filament\Resources\Pages\ViewRecord;

class ViewApprovedPeople extends ViewRecord
{
    protected static string $resource = ApprovedPeopleResource::class;
    protected function getHeaderActions(): array
    {
        return [];
    }
}

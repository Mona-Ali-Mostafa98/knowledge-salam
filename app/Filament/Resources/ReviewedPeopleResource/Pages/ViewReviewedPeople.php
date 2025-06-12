<?php

namespace App\Filament\Resources\ReviewedPeopleResource\Pages;

use App\Filament\Resources\ReviewedPeopleResource;
use Filament\Resources\Pages\ViewRecord;

class ViewReviewedPeople extends ViewRecord
{
    protected static string $resource = ReviewedPeopleResource::class;
    protected function getHeaderActions(): array
    {
        return [];
    }
}

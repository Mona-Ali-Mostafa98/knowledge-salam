<?php

namespace App\Filament\Resources\ReviewedPeopleResource\Pages;

use App\Filament\Resources\ReviewedPeopleResource;
use App\Filament\Resources\PeopleResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewReviewedPeople extends ViewRecord
{
    protected static string $resource = ReviewedPeopleResource::class;
}

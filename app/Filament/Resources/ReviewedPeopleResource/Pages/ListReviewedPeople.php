<?php

namespace App\Filament\Resources\ReviewedPeopleResource\Pages;

use App\Filament\Resources\ReviewedPeopleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReviewedPeople extends ListRecords
{
    protected static string $resource = ReviewedPeopleResource::class;
}

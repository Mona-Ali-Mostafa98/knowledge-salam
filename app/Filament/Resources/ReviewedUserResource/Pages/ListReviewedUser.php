<?php

namespace App\Filament\Resources\ReviewedUserResource\Pages;

use App\Filament\Resources\ReviewedUserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReviewedUser extends ListRecords
{
    protected static string $resource = ReviewedUserResource::class;
}

<?php

namespace App\Filament\Resources\ReviewedUserResource\Pages;

use App\Filament\Resources\ReviewedUserResource;
use Filament\Resources\Pages\ViewRecord;

class ViewReviewedUser extends ViewRecord
{
    protected static string $resource = ReviewedUserResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}

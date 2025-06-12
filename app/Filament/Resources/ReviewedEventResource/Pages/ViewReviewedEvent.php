<?php

namespace App\Filament\Resources\ReviewedEventResource\Pages;

use App\Filament\Resources\ReviewedEventResource;
use Filament\Resources\Pages\ViewRecord;

class ViewReviewedEvent extends ViewRecord
{
    protected static string $resource = ReviewedEventResource::class;
    protected function getHeaderActions(): array
    {
        return [];
    }
}

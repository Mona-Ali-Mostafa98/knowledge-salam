<?php

namespace App\Filament\Resources\ReviewedOrganizationResource\Pages;

use App\Filament\Resources\ReviewedOrganizationResource;
use Filament\Resources\Pages\ViewRecord;

class ViewReviewedOrganization extends ViewRecord
{
    protected static string $resource = ReviewedOrganizationResource::class;
    protected function getHeaderActions(): array
    {
        return [];
    }
}

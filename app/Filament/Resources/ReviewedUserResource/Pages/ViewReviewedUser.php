<?php

namespace App\Filament\Resources\ReviewedUserResource\Pages;

use App\Filament\Resources\ReviewedUserResource;
use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewReviewedUser extends ViewRecord
{
    protected static string $resource = ReviewedUserResource::class;
}

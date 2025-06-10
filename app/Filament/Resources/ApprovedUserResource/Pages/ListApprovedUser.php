<?php

namespace App\Filament\Resources\ApprovedUserResource\Pages;

use App\Filament\Resources\ApprovedUserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListApprovedUser extends ListRecords
{
    protected static string $resource = ApprovedUserResource::class;
}

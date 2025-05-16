<?php

namespace App\Filament\Resources\IssuesResource\Pages;

use App\Filament\Resources\IssuesResource;
use Filament\Resources\Pages\CreateRecord;

class CreateIssues extends CreateRecord
{
    protected static string $resource = IssuesResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

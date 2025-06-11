<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ApprovedOrganizationResource\Pages\EditApprovedOrganization;
use App\Filament\Resources\ApprovedOrganizationResource\Pages\ListApprovedOrganization;
use App\Filament\Resources\ApprovedOrganizationResource\Pages\ViewApprovedOrganization;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


class ApprovedOrganizationResource extends OrganizationResource
{
    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $model = Organization::class;

    protected static ?string $navigationGroup = 'Approved Records';
    protected static ?string $label = 'Approved Organization';
    protected static ?string $pluralLabel = 'Approved Organizations';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([SoftDeletingScope::class])
            ->where('approval_status', 'approved');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListApprovedOrganization::route('/'),
            'view' => ViewApprovedOrganization::route('/{record}'),
            'edit' => EditApprovedOrganization::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('approval_status', 'approved')->count();
    }
}
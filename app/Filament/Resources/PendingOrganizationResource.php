<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PendingOrganizationResource\Pages\EditPendingOrganization;
use App\Filament\Resources\PendingOrganizationResource\Pages\ListPendingOrganization;
use App\Filament\Resources\PendingOrganizationResource\Pages\ViewPendingOrganization;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


class PendingOrganizationResource extends OrganizationResource
{
    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $model = Organization::class;

    protected static ?string $navigationGroup = 'Pending Records';
    protected static ?string $label = 'Pending Organization';
    protected static ?string $pluralLabel = 'Pending Organizations';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([SoftDeletingScope::class])
            ->where('approval_status', 'pending');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPendingOrganization::route('/'),
            'view' => ViewPendingOrganization::route('/{record}'),
            'edit' => EditPendingOrganization::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('approval_status', 'pending')->count();
    }
}

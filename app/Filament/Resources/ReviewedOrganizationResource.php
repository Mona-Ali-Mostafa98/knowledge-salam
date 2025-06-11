<?php

namespace App\Filament\Resources;

use App\Models\Organization;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


class ReviewedOrganizationResource extends OrganizationResource
{
    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $model = Organization::class;

    protected static ?string $navigationGroup = 'Reviewed Records';
    protected static ?string $label = 'Reviewed Organization';
    protected static ?string $pluralLabel = 'Reviewed Organizations';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([SoftDeletingScope::class])
            ->where('approval_status', 'reviewed');
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\ReviewedOrganizationResource\Pages\ListReviewedOrganization::route('/'),
            'view' => \App\Filament\Resources\ReviewedOrganizationResource\Pages\ViewReviewedOrganization::route('/{record}'),
            'edit' => \App\Filament\Resources\ReviewedOrganizationResource\Pages\EditReviewedOrganization::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('approval_status', 'reviewed')->count();
    }
}
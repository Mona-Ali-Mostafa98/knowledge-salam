<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ApprovedPeopleResource\Pages\EditApprovedPeople;
use App\Filament\Resources\ApprovedPeopleResource\Pages\ListApprovedPeople;
use App\Filament\Resources\ApprovedPeopleResource\Pages\ViewApprovedPeople;
use App\Models\Person;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


class ApprovedPeopleResource extends PersonResource
{
    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $model = Person::class;

    protected static ?string $navigationGroup = 'Approved Records';
    protected static ?string $label = 'Approved People';
    protected static ?string $pluralLabel = 'Approved Peoples';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([SoftDeletingScope::class])
            ->where('approval_status', 'approved');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListApprovedPeople::route('/'),
            'view' => ViewApprovedPeople::route('/{record}'),
            'edit' => EditApprovedPeople::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('approval_status', 'approved')->count();
    }
}

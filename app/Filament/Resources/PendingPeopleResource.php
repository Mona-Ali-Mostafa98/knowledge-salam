<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PendingPeopleResource\Pages\EditPendingPeople;
use App\Filament\Resources\PendingPeopleResource\Pages\ListPendingPeople;
use App\Filament\Resources\PendingPeopleResource\Pages\ViewPendingPeople;
use App\Models\Person;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


class PendingPeopleResource extends PersonResource
{
    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $model = Person::class;

    protected static ?string $navigationGroup = 'Pending Records';
    protected static ?string $label = 'Pending People';
    protected static ?string $pluralLabel = 'Pending Peoples';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([SoftDeletingScope::class])
            ->where('approval_status', 'pending');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPendingPeople::route('/'),
            'view' => ViewPendingPeople::route('/{record}'),
            'edit' => EditPendingPeople::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('approval_status', 'pending')->count();
    }
}
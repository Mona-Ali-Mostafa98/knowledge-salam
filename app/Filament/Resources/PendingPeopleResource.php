<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PendingPeopleResource\Pages\ListPendingPeople;
use App\Filament\Resources\PendingPeopleResource\Pages\ViewPendingPeople;
use App\Models\Person;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


class PendingPeopleResource extends PersonResource
{
    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $model = Person::class;

    public static function getNavigationGroup(): ?string
    {
        return __('system.Pending Records');
    }

    public static function getPluralLabel(): ?string
    {
        return __('system.People Records need to reviewed');
    }

    public static function getLabel(): ?string
    {
        return  __('system.People Records need to pending');
    }

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
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('approval_status', 'pending')->count();
    }

    public static function canAccess(): bool
    {
        $user = Filament::auth()->user();

        return $user && method_exists($user, 'hasRole') && $user->hasRole('reviewer');
    }
}

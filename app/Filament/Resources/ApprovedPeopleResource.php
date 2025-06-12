<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ApprovedPeopleResource\Pages\ListApprovedPeople;
use App\Filament\Resources\ApprovedPeopleResource\Pages\ViewApprovedPeople;
use App\Models\Person;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


class ApprovedPeopleResource extends PersonResource
{
    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $model = Person::class;

    public static function getNavigationGroup(): ?string
    {
        return __('system.Approval Records');
    }

    public static function getPluralLabel(): ?string
    {
        return __('system.People Records need to approved');
    }

    public static function getLabel(): ?string
    {
        return  __('system.People Records need to approved');
    }

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
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('approval_status', 'approved')->count();
    }

    public static function canAccess(): bool
    {
        $user = Filament::auth()->user();

        return $user && method_exists($user, 'hasRole') && $user->hasRole(['publisher', 'super_admin']);
    }
}

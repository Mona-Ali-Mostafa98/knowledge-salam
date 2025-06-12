<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReviewedPeopleResource\Pages\ListReviewedPeople;
use App\Filament\Resources\ReviewedPeopleResource\Pages\ViewReviewedPeople;
use App\Models\Person;
use Filament\Facades\Filament;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


class ReviewedPeopleResource extends PersonResource
{
    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $model = Person::class;

    public static function getNavigationGroup(): ?string
    {
        return __('system.Reviewed Records');
    }

    public static function getPluralLabel(): ?string
    {
        return __('system.People Records need to reviewed');
    }

    public static function getLabel(): ?string
    {
        return  __('system.People Records need to reviewed');
    }


    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([SoftDeletingScope::class])
            ->where('approval_status', 'reviewed');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListReviewedPeople::route('/'),
            'view' => ViewReviewedPeople::route('/{record}'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('approval_status', 'reviewed')->count();
    }

    public static function canAccess(): bool
    {
        $user = Filament::auth()->user();

        return $user && method_exists($user, 'hasRole') && $user->hasRole('approval');
    }

    public static function table(Table $table): Table
    {
        return parent::table($table)
            ->actions([
                \Filament\Tables\Actions\ViewAction::class::make(),
            ]);
    }
}

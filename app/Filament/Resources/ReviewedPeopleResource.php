<?php

namespace App\Filament\Resources;

use App\Models\Person;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


class ReviewedPeopleResource extends PersonResource
{
    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $model = Person::class;

    protected static ?string $navigationGroup = 'Reviewed Records';
    protected static ?string $label = 'Reviewed People';
    protected static ?string $pluralLabel = 'Reviewed Peoples';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([SoftDeletingScope::class])
            ->where('approval_status', 'reviewed');
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\ReviewedPeopleResource\Pages\ListReviewedPeople::route('/'),
            'view' => \App\Filament\Resources\ReviewedPeopleResource\Pages\ViewReviewedPeople::route('/{record}'),
            'edit' => \App\Filament\Resources\ReviewedPeopleResource\Pages\EditReviewedPeople::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('approval_status', 'reviewed')->count();
    }
}
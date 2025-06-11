<?php

namespace App\Filament\Resources;

use App\Models\Event;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


class ReviewedEventResource extends EventResource
{
    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $model = Event::class;

    protected static ?string $navigationGroup = 'Reviewed Records';
    protected static ?string $label = 'Reviewed Event';
    protected static ?string $pluralLabel = 'Reviewed Events';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([SoftDeletingScope::class])
            ->where('approval_status', 'reviewed');
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\ReviewedEventResource\Pages\ListReviewedEvent::route('/'),
            'view' => \App\Filament\Resources\ReviewedEventResource\Pages\ViewReviewedEvent::route('/{record}'),
            'edit' => \App\Filament\Resources\ReviewedEventResource\Pages\EditReviewedEvent::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('approval_status', 'reviewed')->count();
    }
}

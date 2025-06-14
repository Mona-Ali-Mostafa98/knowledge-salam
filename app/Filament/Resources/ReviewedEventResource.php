<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReviewedEventResource\Pages\ListReviewedEvent;
use App\Filament\Resources\ReviewedEventResource\Pages\ViewReviewedEvent;
use App\Models\Event;
use Filament\Facades\Filament;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


class ReviewedEventResource extends EventResource
{
    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $model = Event::class;

    public static function getNavigationGroup(): ?string
    {
        return __('system.Reviewed Records');
    }

    public static function getPluralLabel(): ?string
    {
        return __('system.Events Records need to reviewed');
    }

    public static function getLabel(): ?string
    {
        return  __('system.Events Records need to reviewed');
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
            'index' => ListReviewedEvent::route('/'),
            'view' => ViewReviewedEvent::route('/{record}'),
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

}

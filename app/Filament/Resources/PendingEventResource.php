<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PendingEventResource\Pages\ListPendingEvent;
use App\Filament\Resources\PendingEventResource\Pages\ViewPendingEvent;
use App\Models\Event;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


class PendingEventResource extends EventResource
{
    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $model = Event::class;

    //protected static ?string $navigationGroup = 'Pending Records';
    public static function getNavigationGroup(): ?string
    {
        return __('system.Pending Records');
    }

    public static function getPluralLabel(): ?string
    {
        return __('system.Events Records need to pending');
    }

    public static function getLabel(): ?string
    {
        return  __('system.Events Records need to pending');
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
            'index' => ListPendingEvent::route('/'),
            'view' => ViewPendingEvent::route('/{record}'),
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

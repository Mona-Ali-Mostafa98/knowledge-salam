<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PendingEventResource\Pages\EditPendingEvent;
use App\Filament\Resources\PendingEventResource\Pages\ListPendingEvents;
use App\Filament\Resources\PendingEventResource\Pages\ViewPendingEvent;
use App\Models\Event;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


class PendingEventResource extends EventResource
{
    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $model = Event::class;

    protected static ?string $navigationGroup = 'Approvals'; // Or any section you want
    protected static ?string $label = 'Pending Event';
    protected static ?string $pluralLabel = 'Pending Events';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([SoftDeletingScope::class])
            ->where('approval_status', 'pending');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPendingEvents::route('/'),
            'view' => ViewPendingEvent::route('/{record}'),
            'edit' => EditPendingEvent::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('approval_status', 'pending')->count();
    }
}

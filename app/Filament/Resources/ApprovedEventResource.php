<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ApprovedEventResource\Pages\EditApprovedEvent;
use App\Filament\Resources\ApprovedEventResource\Pages\ListApprovedEvent;
use App\Filament\Resources\ApprovedEventResource\Pages\ViewApprovedEvent;
use App\Models\Event;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


class ApprovedEventResource extends EventResource
{
    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $model = Event::class;

    protected static ?string $navigationGroup = 'Approvals'; // Or any section you want
    protected static ?string $label = 'Approved Event';
    protected static ?string $pluralLabel = 'Approved Events';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([SoftDeletingScope::class])
            ->where('approval_status', 'approved');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListApprovedEvent::route('/'),
            'view' => ViewApprovedEvent::route('/{record}'),
            'edit' => EditApprovedEvent::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('approval_status', 'approved')->count();
    }
}

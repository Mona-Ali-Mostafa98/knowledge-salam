<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ApprovedEventResource\Pages\ListApprovedEvent;
use App\Filament\Resources\ApprovedEventResource\Pages\ViewApprovedEvent;
use App\Models\Event;
use Filament\Facades\Filament;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


class ApprovedEventResource extends EventResource
{
    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $model = Event::class;

    public static function getNavigationGroup(): ?string
    {
        return __('system.Approval Records');
    }

    public static function getPluralLabel(): ?string
    {
        return __('system.Events Records need to approved');
    }

    public static function getLabel(): ?string
    {
        return  __('system.Events Records need to approved');
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
            'index' => ListApprovedEvent::route('/'),
            'view' => ViewApprovedEvent::route('/{record}'),
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

    public static function table(Table $table): Table
    {
        return parent::table($table)
            ->actions([
                \Filament\Tables\Actions\ViewAction::class::make(),
            ]);
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PendingUserResource\Pages\EditPendingUser;
use App\Filament\Resources\PendingUserResource\Pages\ListPendingUsers;
use App\Filament\Resources\PendingUserResource\Pages\ViewPendingUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


class PendingUserResource extends UserResource
{
    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $model = User::class;

    protected static ?string $navigationGroup = 'Pending Records';
    protected static ?string $label = 'Pending User';
    protected static ?string $pluralLabel = 'Pending Users';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([SoftDeletingScope::class])
            ->where('approval_status', 'pending');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPendingUsers::route('/'),
            'view' => ViewPendingUser::route('/{record}'),
            'edit' => EditPendingUser::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('approval_status', 'pending')->count();
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PendingUserResource\Pages\ListPendingUser;
use App\Filament\Resources\PendingUserResource\Pages\ViewPendingUser;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


class PendingUserResource extends UserResource
{
    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $model = User::class;

    public static function getNavigationGroup(): ?string
    {
        return __('system.Pending Records');
    }

    public static function getPluralLabel(): ?string
    {
        return __('system.Users Records need to pending');
    }

    public static function getLabel(): ?string
    {
        return  __('system.Users Records need to pending');
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
            'index' => ListPendingUser::route('/'),
            'view' => ViewPendingUser::route('/{record}'),
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

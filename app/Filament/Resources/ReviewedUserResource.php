<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReviewedUserResource\Pages\ListReviewedUser;
use App\Filament\Resources\ReviewedUserResource\Pages\ViewReviewedUser;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


class ReviewedUserResource extends UserResource
{
    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $model = User::class;

    public static function getNavigationGroup(): ?string
    {
        return __('system.Reviewed Records');
    }

    public static function getPluralLabel(): ?string
    {
        return __('system.Users Records need to reviewed');
    }

    public static function getLabel(): ?string
    {
        return  __('system.Users Records need to reviewed');
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
            'index' => ListReviewedUser::route('/'),
            'view' => ViewReviewedUser::route('/{record}'),
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

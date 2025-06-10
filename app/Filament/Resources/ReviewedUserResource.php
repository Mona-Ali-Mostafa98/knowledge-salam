<?php

namespace App\Filament\Resources;

use App\Models\User;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


class ReviewedUserResource extends UserResource
{
    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $model = User::class;

    protected static ?string $navigationGroup = 'Approvals'; // Or any section you want
    protected static ?string $label = 'Reviewed User';
    protected static ?string $pluralLabel = 'Reviewed Users';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([SoftDeletingScope::class])
            ->where('approval_status', 'reviewed');
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\ReviewedUserResource\Pages\ListReviewedUser::route('/'),
            'view' => \App\Filament\Resources\ReviewedUserResource\Pages\ViewReviewedUser::route('/{record}'),
            'edit' => \App\Filament\Resources\ReviewedUserResource\Pages\EditReviewedUser::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('approval_status', 'reviewed')->count();
    }
}

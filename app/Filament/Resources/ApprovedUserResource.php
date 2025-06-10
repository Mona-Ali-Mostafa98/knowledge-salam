<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ApprovedUserResource\Pages\EditApprovedUser;
use App\Filament\Resources\ApprovedUserResource\Pages\ListApprovedUser;
use App\Filament\Resources\ApprovedUserResource\Pages\ViewApprovedUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


class ApprovedUserResource extends UserResource
{
    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $model = User::class;

    protected static ?string $navigationGroup = 'Approvals'; // Or any section you want
    protected static ?string $label = 'Approved User';
    protected static ?string $pluralLabel = 'Approved Users';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([SoftDeletingScope::class])
            ->where('approval_status', 'approved');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListApprovedUser::route('/'),
            'view' => ViewApprovedUser::route('/{record}'),
            'edit' => EditApprovedUser::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('approval_status', 'approved')->count();
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PendingOrganizationResource\Pages\ListPendingOrganization;
use App\Filament\Resources\PendingOrganizationResource\Pages\ViewPendingOrganization;
use App\Models\Organization;
use Filament\Facades\Filament;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


class PendingOrganizationResource extends OrganizationResource
{
    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $model = Organization::class;

    public static function getNavigationGroup(): ?string
    {
        return __('system.Pending Records');
    }

    public static function getPluralLabel(): ?string
    {
        return __('system.Organizations Records need to pending');
    }

    public static function getLabel(): ?string
    {
        return  __('system.Organizations Records need to pending');
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
            'index' => ListPendingOrganization::route('/'),
            'view' => ViewPendingOrganization::route('/{record}'),
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

    public static function table(Table $table): Table
    {
        return parent::table($table)
            ->actions([
                \Filament\Tables\Actions\ViewAction::class::make(),
            ]);
    }
}

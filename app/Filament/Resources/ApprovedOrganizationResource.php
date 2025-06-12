<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ApprovedOrganizationResource\Pages\ListApprovedOrganization;
use App\Filament\Resources\ApprovedOrganizationResource\Pages\ViewApprovedOrganization;
use App\Models\Organization;
use Filament\Facades\Filament;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


class ApprovedOrganizationResource extends OrganizationResource
{
    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $model = Organization::class;

    public static function getNavigationGroup(): ?string
    {
        return __('system.Approval Records');
    }

    public static function getPluralLabel(): ?string
    {
        return __('system.Organizations Records need to approved');
    }

    public static function getLabel(): ?string
    {
        return  __('system.Organizations Records need to approved');
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
            'index' => ListApprovedOrganization::route('/'),
            'view' => ViewApprovedOrganization::route('/{record}'),
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

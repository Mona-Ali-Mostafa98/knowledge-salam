<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReviewedOrganizationResource\Pages\ListReviewedOrganization;
use App\Filament\Resources\ReviewedOrganizationResource\Pages\ViewReviewedOrganization;
use App\Models\Organization;
use Filament\Facades\Filament;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


class ReviewedOrganizationResource extends OrganizationResource
{
    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $model = Organization::class;

    public static function getNavigationGroup(): ?string
    {
        return __('system.Reviewed Records');
    }

    public static function getPluralLabel(): ?string
    {
        return __('system.Organizations Records need to reviewed');
    }

    public static function getLabel(): ?string
    {
        return  __('system.Organizations Records need to reviewed');
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
            'index' => ListReviewedOrganization::route('/'),
            'view' => ViewReviewedOrganization::route('/{record}'),
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

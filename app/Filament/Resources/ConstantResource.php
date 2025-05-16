<?php

namespace App\Filament\Resources;

use App\Enum\ConstantsTypes;
use App\Filament\Resources\ConstantResource\Pages;
use App\Models\Constant;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use SolutionForest\FilamentTranslateField\Forms\Component\Translate;

class ConstantResource extends Resource
{
    protected static ?string $model = Constant::class;

    protected static ?string $langFile = 'system';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make([
                    Translate::make()
                        ->schema(fn (string $locale) => [
                            Forms\Components\TextInput::make('name')
                                ->required()
                                ->label(__(self::$langFile.'.name'))
                                ->maxLength(100)
                                ->required($locale == 'ar'),
                        ])->locales(['ar', 'en']),
                    Forms\Components\Select::make('type')
                        ->options(ConstantsTypes::class)
                        ->label(__(self::$langFile.'.type'))
                        ->required(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__(self::$langFile.'.name'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type_translated')
                    ->label(__(self::$langFile.'.type')),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__(self::$langFile.'.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                Tables\Filters\SelectFilter::make('type')
                    ->options(ConstantsTypes::class)
                    ->label(__(self::$langFile.'.type')),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListConstants::route('/'),
            'create' => Pages\CreateConstant::route('/create'),
            'view' => Pages\ViewConstant::route('/{record}'),
            'edit' => Pages\EditConstant::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getNavigationGroup(): ?string
    {
        return __('system.system_constants');
    }

    public static function getPluralLabel(): ?string
    {
        return __(self::$langFile.'.constants');
    }

    public static function getLabel(): ?string
    {
        return __(self::$langFile.'.constant');
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}

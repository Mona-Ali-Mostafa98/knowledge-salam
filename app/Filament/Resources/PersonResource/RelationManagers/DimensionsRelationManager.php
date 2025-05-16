<?php

namespace App\Filament\Resources\PersonResource\RelationManagers;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class DimensionsRelationManager extends RelationManager
{
    protected static string $relationship = 'dimensions';

    protected static ?string $langFile = 'person';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('dimension_id')
                    ->relationship('dimension', 'name')
                    ->required()
                    ->label(__(self::$langFile.'.dimension_id')),
                Textarea::make('details')
                    ->label(__(self::$langFile.'.details'))
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('dimension.name')
                    ->label(__(self::$langFile.'.dimension_id')),
                Tables\Columns\TextColumn::make('details')
                    ->label(__(self::$langFile.'.details'))
                    ->words(5)
                    ->wrap(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __(self::$langFile.'.dimensions');
    }

    public static function getModelLabel(): ?string
    {
        return __(self::$langFile.'.dimension');
    }
}

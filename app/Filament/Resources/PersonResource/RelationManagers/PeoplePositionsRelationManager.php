<?php

namespace App\Filament\Resources\PersonResource\RelationManagers;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class PeoplePositionsRelationManager extends RelationManager
{
    protected static string $relationship = 'people_positions';

    protected static string $langFile = 'person';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('political_position_id')
                    ->relationship('political_position', 'name')
                    ->label(__(self::$langFile.'.political_position_id'))
                    ->required(),
                Textarea::make('person_position')
                    ->label(__(self::$langFile.'.person_position'))
                    ->required(),
                Textarea::make('saudi_position')
                    ->label(__(self::$langFile.'.saudi_position'))
                    ->required(),
            ])->columns(1);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('political_position.name')
                    ->label(__(self::$langFile.'.political_position_id')),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
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
        return __(self::$langFile.'.people_positions_tab');
    }

    public static function getModelLabel(): ?string
    {
        return __(self::$langFile.'.people_position');
    }
}

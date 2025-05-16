<?php

namespace App\Filament\Resources\PersonResource\RelationManagers;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class FactsRelationManager extends RelationManager
{
    protected static string $relationship = 'facts';

    protected static ?string $langFile = 'person';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('achievement_id')
                    ->relationship('achievement', 'name')
                    ->label(__(self::$langFile.'.achievement_id'))
                    ->required(),
                Textarea::make('details')
                    ->label(__(self::$langFile.'.details'))
                    ->required(),
                DateTimePicker::make('fact_date')
                    ->label(__(self::$langFile.'.fact_date'))
                    ->default(now()),
            ])->columns(1);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('details')
                    ->label(__(self::$langFile.'.details'))
                    ->words(5)
                    ->wrap(),
                Tables\Columns\TextColumn::make('fact_date')
                    ->label(__(self::$langFile.'.fact_date')),
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
        return __(self::$langFile.'.facts');
    }

    public static function getModelLabel(): ?string
    {
        return __(self::$langFile.'.fact');
    }
}

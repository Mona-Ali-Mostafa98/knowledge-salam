<?php

namespace App\Filament\Resources\PersonResource\RelationManagers;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class OrientationsRelationManager extends RelationManager
{
    protected static string $relationship = 'orientations';

    protected static ?string $langFile = 'person';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Toggle::make('has_party')
                    ->label(__(self::$langFile.'.has_party')),
                Select::make('parties_id')
                    ->relationship('parties', 'name')
                    ->label(__(self::$langFile.'.parties_id')),
                Select::make('orientation_id')
                    ->relationship('orientation', 'name')
                    ->label(__(self::$langFile.'.orientation_id')),
                Select::make('commitment_id')
                    ->relationship('commitment', 'name')
                    ->label(__(self::$langFile.'.commitment_id')),
                Textarea::make('political_positions')
                    ->label(__(self::$langFile.'.political_positions'))
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('saudi_issue_position')
                    ->label(__(self::$langFile.'.saudi_issue_position'))
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('meeting_points')
                    ->label(__(self::$langFile.'.meeting_points'))
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('parties.name')
                    ->label(__(self::$langFile.'.parties_id')),
                Tables\Columns\TextColumn::make('orientation.name')
                    ->label(__(self::$langFile.'.orientation_id')),
                Tables\Columns\TextColumn::make('commitment.name')
                    ->label(__(self::$langFile.'.commitment_id')),
                //                Tables\Columns\TextColumn::make('political_positions')
                //                    ->label(__(self::$langFile.'.political_positions')),
                //                Tables\Columns\TextColumn::make('statements')
                //                    ->label(__(self::$langFile.'.statements')),
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
        return __(self::$langFile.'.orientations');
    }

    public static function getModelLabel(): ?string
    {
        return __(self::$langFile.'.orientation');
    }
}

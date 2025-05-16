<?php

namespace App\Filament\Resources\PersonResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class IssuesRelationManager extends RelationManager
{
    protected static string $relationship = 'issues';

    protected static ?string $langFile = 'person';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label(__(self::$langFile.'.issue_title'))
                    ->required(),
                Forms\Components\Select::make('saudi_direction_id')
                    ->label(__(self::$langFile.'.saudi_direction_id'))
                    ->relationship('saudi_direction', 'name'),
                Forms\Components\DatePicker::make('start')
                    ->label(__(self::$langFile.'.start_date'))
                    ->default(now()),
                Forms\Components\DatePicker::make('end')
                    ->label(__(self::$langFile.'.end_date'))
                    ->default(now()),
                Forms\Components\TagsInput::make('tags')
                    ->separator(',')
                    ->label(__(self::$langFile.'.tags')),
                Forms\Components\Select::make('sector_id')
                    ->label(__(self::$langFile.'.sector_id'))
                    ->relationship('sector', 'name'),
                Textarea::make('details')
                    ->label(__(self::$langFile.'.details')),
                Textarea::make('related_points')
                    ->label(__(self::$langFile.'.related_points')),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label(__(self::$langFile.'.issue_title')),
                Tables\Columns\TextColumn::make('saudi_direction.name')
                    ->label(__(self::$langFile.'.saudi_direction_id')),
                Tables\Columns\TextColumn::make('start')
                    ->label(__(self::$langFile.'.start_date')),
                Tables\Columns\TextColumn::make('end')
                    ->label(__(self::$langFile.'.end_date')),
                Tables\Columns\TextColumn::make('sector.name')
                    ->label(__(self::$langFile.'.sector_id')),
                Tables\Columns\TextColumn::make('tags')
                    ->separator(',')
                    ->badge()
                    ->label(__(self::$langFile.'.tags')),
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
        return __(self::$langFile.'.issues_tab');
    }

    public static function getModelLabel(): ?string
    {
        return __(self::$langFile.'.issue');
    }
}

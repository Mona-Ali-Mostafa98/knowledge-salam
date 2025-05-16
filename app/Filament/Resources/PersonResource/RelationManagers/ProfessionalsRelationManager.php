<?php

namespace App\Filament\Resources\PersonResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ProfessionalsRelationManager extends RelationManager
{
    protected static string $relationship = 'professionals';

    protected static ?string $langFile = 'person';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('organization_type_id')
                    ->relationship('organization_type', 'name')
                    ->label(__(self::$langFile.'.organization_type_id'))
                    ->required(),
                Select::make('organization_level_id')
                    ->relationship('organization_level', 'name')
                    ->label(__(self::$langFile.'.organization_level_id'))
                    ->required(),

                Select::make('institution_type_id')
                    ->relationship('institution_type', 'name')
                    ->label(__(self::$langFile.'.institution_type_id'))
                    ->required(),
                Forms\Components\TextInput::make('institution')
                    ->required()
                    ->label(__(self::$langFile.'.institution'))
                    ->maxLength(200),

                Select::make('position_id')
                    ->relationship('position', 'name')
                    ->label(__(self::$langFile.'.position_id'))
                    ->required(),
                Select::make('specialization_id')
                    ->relationship('specialization', 'name')
                    ->label(__(self::$langFile.'.specialization_id'))
                    ->required(),
                Forms\Components\DatePicker::make('start')
                    ->label(__(self::$langFile.'.start')),
                Forms\Components\DatePicker::make('end')
                    ->label(__(self::$langFile.'.end')),

                Select::make('influence_level_id')
                    ->relationship('influence_level', 'name')
                    ->label(__(self::$langFile.'.influence_level_id'))
                    ->required(),

                Forms\Components\Textarea::make('description')
                    ->label(__(self::$langFile.'.description'))
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('institution')
                    ->label(__(self::$langFile.'.institution'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('position.name')
                    ->label(__(self::$langFile.'.position'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('influence_level.name')
                    ->label(__(self::$langFile.'.influence'))
                    ->words(5)
                    ->searchable(),
                Tables\Columns\TextColumn::make('start')
                    ->label(__(self::$langFile.'.start'))
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end')
                    ->label(__(self::$langFile.'.end'))
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__(self::$langFile.'.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
        return __(self::$langFile.'.professionals');
    }

    public static function getModelLabel(): ?string
    {
        return __(self::$langFile.'.professional');
    }
}

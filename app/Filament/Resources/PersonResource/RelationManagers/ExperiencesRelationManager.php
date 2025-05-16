<?php

namespace App\Filament\Resources\PersonResource\RelationManagers;

use App\Enum\Qualification;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ExperiencesRelationManager extends RelationManager
{
    protected static string $relationship = 'experiences';

    protected static ?string $langFile = 'person';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('institution')
                    ->required()
                    ->label(__(self::$langFile.'.institution'))
                    ->maxLength(255),
                Select::make('qualification')
                    ->options(Qualification::class)
                    ->label(__(self::$langFile.'.qualification'))
                    ->required(),
                TextInput::make('start')
                    ->label(__(self::$langFile.'.start_date'))
                    ->numeric()
                    ->minValue(1900)
                    ->default(now()->year)
                    ->required(),
                TextInput::make('end')
                    ->label(__(self::$langFile.'.end_date'))
                    ->numeric()
                    ->minValue(1900)
                    ->default(now()->year)
                    ->required(),
                //                Textarea::make('experience')
                //                    ->label(__(self::$langFile.'.experience')),
                Select::make('specializations_id')
                    ->relationship('specialization', 'name')
                    ->label(__(self::$langFile.'.specializations_id'))
                    ->required(),
                Select::make('influence_id')
                    ->relationship('influence_level', 'name')
                    ->label(__(self::$langFile.'.influence_id'))
                    ->required(),
                Textarea::make('details')
                    ->columnSpanFull()
                    ->label(__(self::$langFile.'.experience_details')),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('institution')
            ->columns([
                Tables\Columns\TextColumn::make('institution')
                    ->label(__(self::$langFile.'.institution')),
                Tables\Columns\TextColumn::make('qualification_translated')
                    ->label(__(self::$langFile.'.qualification')),
                Tables\Columns\TextColumn::make('specialization.name')
                    ->label(__(self::$langFile.'.specializations_id')),
                Tables\Columns\TextColumn::make('start')
                    ->label(__(self::$langFile.'.start_date')),
                Tables\Columns\TextColumn::make('end')
                    ->label(__(self::$langFile.'.end_date')),
                //                Tables\Columns\TextColumn::make('details')
                //                    ->label(__(self::$langFile.'.details')),
                //                Tables\Columns\TextColumn::make('experience')
                //                    ->label(__(self::$langFile.'.experience')),
                Tables\Columns\TextColumn::make('influence_level.name')
                    ->label(__(self::$langFile.'.influence_id')),
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
        return __(self::$langFile.'.experiences');
    }

    public static function getModelLabel(): ?string
    {
        return __(self::$langFile.'.experiences_single');
    }
}

<?php

namespace App\Filament\Resources\OrganizationResource\RelationManagers;

use App\Enum\Actions;
use App\Enum\Models;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class LogsRelationManager extends RelationManager
{
    protected static string $relationship = 'logs';

    protected static ?string $langFile = 'organization';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make('model')
                    ->default(Models::Organization->value),
                Hidden::make('action')
                    ->default(Actions::Review->value),
                Hidden::make('creator_id')
                    ->default(auth()->user()->getAuthIdentifier()),
                Hidden::make('reviewer_id')
                    ->default(auth()->user()->getAuthIdentifier()),
                Hidden::make('action_date')
                    ->default(now()),
                Textarea::make('note')
                    ->label(__(self::$langFile.'.note'))
                    ->columnSpanFull()
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('creator.name')
                    ->label(__(self::$langFile.'.creator_id')),
                Tables\Columns\TextColumn::make('reviewer.name')
                    ->label(__(self::$langFile.'.reviewer_id')),
                Tables\Columns\TextColumn::make('action_date')
                    ->label(__(self::$langFile.'.action_date')),
                Tables\Columns\TextColumn::make('note')
                    ->label(__(self::$langFile.'.note')),
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
        return __(self::$langFile.'.logs');
    }

    public static function getModelLabel(): ?string
    {
        return __(self::$langFile.'.log');
    }
}

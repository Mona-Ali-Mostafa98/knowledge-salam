<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SaudiPositionsResource\Pages;
use App\Models\SaudiPositions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SaudiPositionsResource extends Resource
{
    protected static ?string $model = SaudiPositions::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-path-rounded-square';

    protected static ?int $navigationSort = 4;

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    protected static ?string $langFile = 'system';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make([
                    Forms\Components\TextInput::make('title')
                        ->label(__(self::$langFile.'.position_title')),
                    Forms\Components\Select::make('person_id')
                        ->label(__(self::$langFile.'.person_id'))
                        ->relationship(
                            name: 'person',
                            modifyQueryUsing: fn (Builder $query) => $query->orderBy('first_name')->orderBy('last_name'),
                        )
                        ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->first_name} {$record->mid_name} {$record->last_name}")
                        ->required(),
                    Forms\Components\DateTimePicker::make('date')
                        ->label(__(self::$langFile.'.date'))
                        ->default(now()),
                    Forms\Components\Select::make('direction_id')
                        ->relationship('direction', 'name')
                        ->label(__(self::$langFile.'.direction_id'))
                        ->default(null),
                    Forms\Components\Select::make('sector_id')
                        ->label(__(self::$langFile.'.sector_id'))
                        ->relationship('sector', 'name')
                        ->required(),
                    Forms\Components\TagsInput::make('tags')
                        ->separator(',')
                        ->label(__(self::$langFile.'.tags')),
                    Forms\Components\Textarea::make('details')
                        ->label(__(self::$langFile.'.details'))
                        ->maxLength(255)
                        ->columnSpanFull()
                        ->default(null),
                ])->columns(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label(__(self::$langFile.'.position_title')),
                Tables\Columns\TextColumn::make('person.name')
                    ->label(__(self::$langFile.'.person_id')),
                Tables\Columns\TextColumn::make('date')
                    ->label(__(self::$langFile.'.date'))
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('direction.name')
                    ->label(__(self::$langFile.'.direction_id'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sector.name')
                    ->label(__(self::$langFile.'.sector_id'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__(self::$langFile.'.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
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
            'index' => Pages\ListSaudiPositions::route('/'),
            'create' => Pages\CreateSaudiPositions::route('/create'),
            'edit' => Pages\EditSaudiPositions::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getPluralLabel(): ?string
    {
        return __(self::$langFile.'.saudi_positions');
    }

    public static function getLabel(): ?string
    {
        return __(self::$langFile.'.saudi_position');
    }
}

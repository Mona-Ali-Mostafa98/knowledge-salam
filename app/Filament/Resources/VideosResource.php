<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VideosResource\Pages;
use App\Models\Videos;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VideosResource extends Resource
{
    protected static ?string $model = Videos::class;

    protected static ?string $langFile = 'system';

    protected static ?string $navigationIcon = 'heroicon-o-video-camera';

    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make([
                    Select::make('position_type_id')
                        ->relationship('position_type', 'name')
                        ->label(__(self::$langFile.'.position_type_id')),

                    Forms\Components\TextInput::make('title')
                        ->label(__(self::$langFile.'.video_title'))
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Select::make('person_id')
                        ->label(__(self::$langFile.'.person_id'))
                        ->relationship(
                            name: 'person',
                            modifyQueryUsing: fn (Builder $query) => $query->orderBy('first_name')->orderBy('last_name'),
                        )
                        ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->first_name} {$record->mid_name} {$record->last_name}")
                        ->required(),
                    Forms\Components\TextInput::make('video_link')
                        ->label(__(self::$langFile.'.video_link'))
                        ->url()
                        ->required()
                        ->maxLength(255),
                    Forms\Components\DateTimePicker::make('publish_date')
                        ->label(__(self::$langFile.'.publish_date'))
                        ->default(now()),
                    Forms\Components\Textarea::make('details')
                        ->label(__(self::$langFile.'.video_details')),
                    Forms\Components\TagsInput::make('tags')
                        ->separator(',')
                        ->label(__(self::$langFile.'.tags')),
                    Forms\Components\Select::make('direction_id')
                        ->label(__(self::$langFile.'.direction_id'))
                        ->relationship('direction', 'name')
                        ->default(null),
                ])->columns(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('person.name')
                    ->label(__(self::$langFile.'.person_id'))
                    ->searchable()
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->label(__(self::$langFile.'.title'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('video_link')
                    ->label(__(self::$langFile.'.video_link')),
                Tables\Columns\TextColumn::make('publish_date')
                    ->label(__(self::$langFile.'.publish_date'))
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('direction.name')
                    ->label(__(self::$langFile.'.direction_id'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__(self::$langFile.'.created_at'))
                    ->dateTime()
                    ->sortable(),
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
            'index' => Pages\ListVideos::route('/'),
            'create' => Pages\CreateVideos::route('/create'),
            'edit' => Pages\EditVideos::route('/{record}/edit'),
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
        return __(self::$langFile.'.videos');
    }

    public static function getLabel(): ?string
    {
        return __(self::$langFile.'.video');
    }
}

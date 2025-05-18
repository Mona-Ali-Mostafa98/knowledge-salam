<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Models\Event;
use App\Models\Person;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use SolutionForest\FilamentTranslateField\Forms\Component\Translate;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $langFile = 'system';

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make([
                    Translate::make()
                        ->schema(fn (string $locale) => [
                            TextInput::make('title')
                                ->required()
                                ->label(__(self::$langFile.'.title'))
                                ->maxLength(100)
                                ->required($locale == 'ar'),
                    ])->locales(['ar', 'en']),
                    Select::make('country_id')
                        ->relationship('country', 'name')
                        ->label(__(self::$langFile.'.country_id')),
                    Select::make('city_id')
                        ->relationship('city', 'name')
                        ->label(__(self::$langFile.'.city_id')),
                    TextInput::make('venue') // new
                        ->label(__(self::$langFile.'.venue'))
                        ->maxLength(100),
                    Select::make('sector_id')
                        ->relationship('sector', 'name')
                        ->label(__(self::$langFile.'.sector_id')),
                    DatePicker::make('event_date')
                        ->label(__(self::$langFile.'.event_date'))
                        ->default(now()),
                    Textarea::make('details')
                        ->label(__(self::$langFile.'.details'))
                        ->columnSpanFull(),
                    Select::make('event_type') // new
                        ->options([
                            'article' => 'Article',
                            'tweet' => 'Tweet',
                            'video' => 'Video',
                            'report' => 'Report',
                            'conference' => 'Conference',
                            'workshop' => 'Workshop',
                            'meeting' => 'Meeting',
                            'seminar' => 'Seminar',
                            'press_release' => 'Press Release',
                            'interview' => 'Interview',
                            'publication' => 'Publication',
                            'announcement' => 'Announcement',
                            'webinar' => 'Webinar',
                            'panel_discussion' => 'Panel Discussion'
                        ])
                        ->label(__(self::$langFile . '.event_type')),
                    Select::make('organization_role_id')
                        ->relationship('organization_role', 'name')
                        ->label(__(self::$langFile.'.organization_role_id')),
                    Textarea::make('organization_position')
                        ->label(__(self::$langFile.'.organization_position'))
                        ->columnSpanFull(),
                    Textarea::make('saudi_direction')
                        ->label(__(self::$langFile.'.saudi_direction'))
                        ->columnSpanFull(),
                    Select::make('saudi_direction_id')
                        ->relationship('saudi_direction', 'name')
                        ->label(__(self::$langFile.'.saudi_direction_id')),
                    TextInput::make('url')
                        ->nullable()
                        ->label(__(self::$langFile.'.url')),
                    Select::make('event_status')
                        ->options([
                            'scheduled' => 'Scheduled',
                            'ongoing' => 'Ongoing',
                            'completed' => 'Completed',
                            'cancelled' => 'Cancelled'
                        ])
                        ->default('scheduled')
                        ->label(__(self::$langFile . '.event_status')),
                    TagsInput::make('tags')
                        ->separator(',')
                        ->label(__(self::$langFile.'.tags')),
                    Select::make('peoples')
                        ->multiple()
                        ->getOptionLabelFromRecordUsing(fn (Person $record) => ($record->name))
                        ->relationship('peoples', 'name')
                        ->label(__(self::$langFile.'.event_peoples'))
                        ->searchable()
                        ->default(null),

                ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label(__(self::$langFile.'.title'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('event_date')
                    ->label(__(self::$langFile.'.event_date'))
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sector.name')
                    ->label(__(self::$langFile.'.sector_id'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('country.name')
                    ->label(__(self::$langFile.'.country_id'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('city.name')
                    ->label(__(self::$langFile.'.city_id'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('organization_role.name')
                    ->label(__(self::$langFile.'.organization_role_id'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('saudi_direction.name')
                    ->label(__(self::$langFile.'.saudi_direction_id'))
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
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
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
        return __(self::$langFile.'.events');
    }

    public static function getLabel(): ?string
    {
        return __(self::$langFile.'.event');
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}

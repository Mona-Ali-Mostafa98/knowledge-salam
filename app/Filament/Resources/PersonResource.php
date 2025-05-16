<?php

namespace App\Filament\Resources;

use App\Enum\MaritalStatus;
use App\Enum\PersonActivity;
use App\Enum\PersonStatus;
use App\Filament\Resources\PersonResource\Pages;
use App\Filament\Resources\PersonResource\RelationManagers\DimensionsRelationManager;
use App\Filament\Resources\PersonResource\RelationManagers\ExperiencesRelationManager;
use App\Filament\Resources\PersonResource\RelationManagers\FactsRelationManager;
use App\Filament\Resources\PersonResource\RelationManagers\IssuesRelationManager;
use App\Filament\Resources\PersonResource\RelationManagers\LogsRelationManager;
use App\Filament\Resources\PersonResource\RelationManagers\OrientationsRelationManager;
use App\Filament\Resources\PersonResource\RelationManagers\PeoplePositionsRelationManager;
use App\Filament\Resources\PersonResource\RelationManagers\ProfessionalsRelationManager;
use App\Models\Person;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Infolists\Components\Actions;
use Filament\Infolists\Components\Actions\Action;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Split;
use Filament\Infolists\Components\Tabs\Tab;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Njxqlus\Filament\Components\Infolists\RelationManager;
use SolutionForest\FilamentTranslateField\Forms\Component\Translate;

class PersonResource extends Resource
{
    protected static ?string $model = Person::class;

    protected static ?string $langFile = 'person';

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Tabs')
                    ->columnSpanFull()
                    ->tabs([
                        Tabs\Tab::make(__(self::$langFile.'.personal_tab'))
                            ->schema([
                                Translate::make()
                                    ->schema(fn (string $locale) => [
                                        TextInput::make('first_name')
                                            ->required()
                                            ->label(__(self::$langFile.'.first_name'))
                                            ->maxLength(100)
                                            ->required($locale == 'ar'),
                                    ])->locales(['ar', 'en']),
                                Translate::make()
                                    ->schema(fn (string $locale) => [
                                        TextInput::make('mid_name')
                                            ->required()
                                            ->label(__(self::$langFile.'.mid_name'))
                                            ->maxLength(100)
                                            ->required($locale == 'ar'),
                                    ])->locales(['ar', 'en']),
                                Translate::make()
                                    ->schema(fn (string $locale) => [
                                        TextInput::make('last_name')
                                            ->required()
                                            ->label(__(self::$langFile.'.last_name'))
                                            ->maxLength(100)
                                            ->required($locale == 'ar'),
                                    ])->locales(['ar', 'en']),

                                DatePicker::make('bod')
                                    ->label(__(self::$langFile.'.bod')),
                                DatePicker::make('death_date')
                                    ->label(__(self::$langFile.'.death_date')),

                                Select::make('nationality_id')
                                    ->relationship('nationality', 'name')
                                    ->label(__(self::$langFile.'.nationality_id')),
                                Select::make('birth_country_id')
                                    ->relationship('birth_country', 'name')
                                    ->reactive()
                                    ->live()
                                    ->label(__(self::$langFile.'.birth_country_id')),
                                Select::make('birth_city_id')
                                    ->relationship('birth_city', 'name', function ($query, Get $get) {
                                        return $query->where('country_id', $get('birth_country_id'));
                                    })
                                    ->label(__(self::$langFile.'.birth_city_id')),
                                TextInput::make('accommodation')
                                    ->maxLength(100)
                                    ->label(__(self::$langFile.'.accommodation'))
                                    ->default(null),
                                Select::make('marital_status')
                                    ->options(MaritalStatus::class)
                                    ->label(__(self::$langFile.'.marital_status')),
                                TextInput::make('partner_name')
                                    ->label(__(self::$langFile.'.partner_name'))
                                    ->default(null),

                                \Filament\Forms\Components\Fieldset::make(__(self::$langFile.'.added_reason'))
                                    ->schema([
                                        Toggle::make('global_influencer')
                                            ->label(__(self::$langFile.'.global_influencer')),
                                        Select::make('fame_reasons_id')
                                            ->relationship('fameReason', 'name')
                                            ->label(__(self::$langFile.'.fame_reasons_id')),
                                        Toggle::make('saudi_interested')
                                            ->label(__(self::$langFile.'.saudi_interested')),

                                        Select::make('status')
                                            ->options(PersonActivity::class)
                                            ->label(__(self::$langFile.'.status')),
                                        Toggle::make('has_issues')
                                            ->label(__(self::$langFile.'.has_issues')),
                                        Textarea::make('issues')
                                            ->label(__(self::$langFile.'.issues')),

                                    ]),

                                Textarea::make('resources')
                                    ->nullable()
                                    ->columnSpanFull()
                                    ->label(__(self::$langFile.'.resources')),
                                //                                Select::make('person_status')
                                //                                    ->options(PersonStatus::class)
                                //                                    ->label(__(self::$langFile.'.person_status')),
                                //                                Textarea::make('added_reason')
                                //                                    ->label(__(self::$langFile.'.added_reason')),
                                //                                Textarea::make('references')
                                //                                    ->label(__(self::$langFile.'.references')),
                            ]),
                        Tabs\Tab::make(__(self::$langFile.'.contact_tab'))
                            ->columns()
                            ->schema([
                                TextInput::make('email')
                                    ->maxLength(200)
                                    ->email()
                                    ->label(__(self::$langFile.'.email'))
                                    ->default(null),
                                TextInput::make('mobile')
                                    ->maxLength(200)
                                    ->tel()
                                    ->label(__(self::$langFile.'.mobile'))
                                    ->default(null),
                                Textarea::make('address')
                                    ->maxLength(250)
                                    ->label(__(self::$langFile.'.address'))
                                    ->default(null),
                            ]),
                        Tabs\Tab::make(__(self::$langFile.'.religiosity_tab'))
                            ->columns()
                            ->schema([
                                Select::make('religion_id')
                                    ->relationship('religion', 'name')
                                    ->label(__(self::$langFile.'.religion_id')),
                                Select::make('sect_id')
                                    ->relationship('sect', 'name')
                                    ->label(__(self::$langFile.'.sect_id')),
                                Select::make('religiosity_id')
                                    ->relationship('religiosity', 'name')
                                    ->label(__(self::$langFile.'.religiosity_id')),
                            ]),
                        Tabs\Tab::make(__(self::$langFile.'.socials_tab'))
                            ->columns()
                            ->schema([
                                Repeater::make('socials')
                                    ->label(__(self::$langFile.'.socials_tab'))
                                    ->relationship()
                                    ->columnSpan(2)
                                    ->columns()
                                    ->grid()
                                    ->schema([
                                        Select::make('type_id')
                                            ->relationship('types', 'name')
                                            ->label(__(self::$langFile.'.social_types'))
                                            ->required(),
                                        TextInput::make('link')
                                            ->url()
                                            ->label(__(self::$langFile.'.link'))
                                            ->required()
                                            ->default(null),
                                        Select::make('status_id')
                                            ->relationship('statuses', 'name')
                                            ->required()
                                            ->label(__(self::$langFile.'.social_status')),
                                        TextInput::make('flower_count')
                                            ->numeric()
                                            ->label(__(self::$langFile.'.flower_count'))
                                            ->default(0),
                                        Select::make('influence_level_id')
                                            ->relationship('influenceLevel', 'name')
                                            ->required()
                                            ->label(__(self::$langFile.'.influence_level_id')),
                                    ]),
                            ]),
                        Tabs\Tab::make(__(self::$langFile.'.influences_tab'))
                            ->columns()
                            ->schema([
                                Repeater::make('influences')
                                    ->label(__(self::$langFile.'.influences_tab'))
                                    ->relationship()
                                    ->columnSpan(2)
                                    ->columns()
                                    ->grid()
                                    ->schema([
                                        Select::make('social_id')
                                            ->relationship('social', 'name')
                                            ->label(__(self::$langFile.'.social_types'))
                                            ->required(),
                                        TextInput::make('flowers')
                                            ->numeric()
                                            ->label(__(self::$langFile.'.flowers'))
                                            ->default(0),
                                        TextInput::make('viewers')
                                            ->numeric()
                                            ->label(__(self::$langFile.'.viewers'))
                                            ->default(0),
                                        TextInput::make('likes')
                                            ->numeric()
                                            ->label(__(self::$langFile.'.likes'))
                                            ->default(0),
                                        TextInput::make('comments')
                                            ->numeric()
                                            ->label(__(self::$langFile.'.comments'))
                                            ->default(0),
                                        DateTimePicker::make('influence_date')
                                            ->label(__(self::$langFile.'.influence_date'))
                                            ->default(now()),
                                        Select::make('event_id')
                                            ->relationship('event', 'title')
                                            ->label(__(self::$langFile.'.event_id')),
                                        Select::make('influence_type_id')
                                            ->relationship('influence_type', 'name')
                                            ->label(__(self::$langFile.'.influence_type_id'))
                                            ->required(),

                                    ]),
                            ]),
                        Tabs\Tab::make(__(self::$langFile.'.attachments_tab'))
                            ->columns()
                            ->schema([
                                FileUpload::make('photo')
                                    ->label(__(self::$langFile.'.photo'))
                                    ->avatar(),
                                FileUpload::make('cv')
                                    ->label(__(self::$langFile.'.cv')),
                            ]),

                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__(self::$langFile.'.name'))
                    ->sortable()
                    ->searchable(['first_name', 'mid_name', 'last_name']),
                TextColumn::make('bod')
                    ->label(__(self::$langFile.'.bod'))
                    ->date()
                    ->sortable(),
                TextColumn::make('nationality.name')
                    ->label(__(self::$langFile.'.nationality_id'))
                    ->sortable(),

                TextColumn::make('religion.name')
                    ->label(__(self::$langFile.'.religion_id'))
                    ->sortable(),
                TextColumn::make('sect.name')
                    ->label(__(self::$langFile.'.sect_id'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('religiosity.name')
                    ->label(__(self::$langFile.'.religiosity_id'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),

                TextColumn::make('birth_country.name')
                    ->label(__(self::$langFile.'.birth_country_id'))
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('birth_city.name')
                    ->label(__(self::$langFile.'.birth_city_id'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('accommodation')
                    ->label(__(self::$langFile.'.accommodation'))
                    ->toggleable()
                    ->searchable(),
                TextColumn::make('marital_status_translated')
                    ->label(__(self::$langFile.'.marital_status'))
                    ->searchable(false)
                    ->toggleable(),
                TextColumn::make('status_translated')
                    ->label(__(self::$langFile.'.status'))
                    ->searchable(false)
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('person_status_translated')
                    ->label(__(self::$langFile.'.person_status'))
                    ->searchable(false)
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label(__(self::$langFile.'.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
                SelectFilter::make('nationality_id')
                    ->relationship('nationality', 'name')
                    ->label(__(self::$langFile.'.nationality_id')),
                SelectFilter::make('religion_id')
                    ->relationship('religion', 'name')
                    ->label(__(self::$langFile.'.religion_id')),
                SelectFilter::make('sect_id')
                    ->relationship('sect', 'name')
                    ->label(__(self::$langFile.'.sect_id')),
                SelectFilter::make('religiosity_id')
                    ->relationship('religiosity', 'name')
                    ->label(__(self::$langFile.'.religiosity_id')),
                SelectFilter::make('marital_status')
                    ->options(MaritalStatus::class)
                    ->label(__(self::$langFile.'.marital_status')),
                SelectFilter::make('status')
                    ->options(PersonActivity::class)
                    ->label(__(self::$langFile.'.status')),
                SelectFilter::make('person_status')
                    ->options(PersonStatus::class)
                    ->label(__(self::$langFile.'.person_status')),
                SelectFilter::make('birth_country_id')
                    ->relationship('birth_country', 'name')
                    ->label(__(self::$langFile.'.birth_country_id')),
                SelectFilter::make('birth_city_id')
                    ->relationship('birth_city', 'name')
                    ->label(__(self::$langFile.'.birth_city_id')),
            ])
            ->actions([
                ViewAction::class::make(),
                EditAction::class::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ExperiencesRelationManager::class,
            ProfessionalsRelationManager::class,
            OrientationsRelationManager::class,
            PeoplePositionsRelationManager::class,
            FactsRelationManager::class,
            DimensionsRelationManager::class,
            IssuesRelationManager::class,
            LogsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPeople::route('/'),
            'create' => Pages\CreatePerson::route('/create'),
            'view' => Pages\ViewPerson::route('/{record}'),
            'edit' => Pages\EditPerson::route('/{record}/edit'),
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
        return __(self::$langFile.'.title');
    }

    public static function getLabel(): ?string
    {
        return __(self::$langFile.'.titleSingle');
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make([
                    Actions::make([
                        Action::make('edit')
                            ->label(__(self::$langFile.'.edit'))
                            ->url(route('filament.admin.resources.people.edit', ['record' => $infolist->record])),
                    ])->alignEnd()
                        ->columnSpanFull(),
                    ImageEntry::make('photo')->circular()
                        ->hiddenLabel()
                        ->alignCenter(),
                    TextEntry::make('name')
                        ->weight(FontWeight::Bold)
                        ->hiddenLabel()
                        ->alignCenter(),
                    Grid::make()
                        ->columns(6)
                        ->schema([
                            TextEntry::make('nationality.name')
                                ->icon('heroicon-o-flag')
                                ->hiddenLabel()
                                ->alignEnd()
                                ->columnSpan(2),
                            TextEntry::make('bod')
                                ->date()
                                ->hiddenLabel()
                                ->icon('heroicon-o-cake')
                                ->alignCenter(),
                            TextEntry::make('mobile')
                                ->icon('heroicon-o-device-phone-mobile')
                                ->hiddenLabel()
                                ->alignCenter(),
                            TextEntry::make('email')
                                ->icon('heroicon-o-envelope')
                                ->hiddenLabel()
                                ->alignStart(),

                        ]),
                    \Filament\Infolists\Components\Tabs::make('Tabs')
                        ->columnSpanFull()
                        ->tabs([
                            Tab::make(__(self::$langFile.'.personal_tab'))
                                ->schema([
                                    Fieldset::make(__(self::$langFile.'.personal_tab'))
                                        ->schema([
                                            TextEntry::make('birth_country.name')
                                                ->label(__(self::$langFile.'.birth_country_id')),
                                            TextEntry::make('birth_city.name')
                                                ->label(__(self::$langFile.'.birth_city_id')),
                                            TextEntry::make('accommodation')
                                                ->label(__(self::$langFile.'.accommodation')),
                                            TextEntry::make('marital_status_translated')
                                                ->label(__(self::$langFile.'.marital_status')),
                                            TextEntry::make('status_translated')
                                                ->label(__(self::$langFile.'.status')),
                                            TextEntry::make('partner_name')
                                                ->label(__(self::$langFile.'.partner_name')),

                                            IconEntry::make('has_issues')
                                                ->boolean()
                                                ->label(__(self::$langFile.'.has_issues')),
                                            TextEntry::make('issues')
                                                ->label(__(self::$langFile.'.issues')),
                                            IconEntry::make('global_influencer')
                                                ->boolean()
                                                ->label(__(self::$langFile.'.global_influencer')),
                                            IconEntry::make('saudi_interested')
                                                ->boolean()
                                                ->label(__(self::$langFile.'.saudi_interested')),
                                            IconEntry::make('fameReason.name')
                                                ->boolean()
                                                ->label(__(self::$langFile.'.fame_reasons_id')),
                                            TextEntry::make('resources')
                                                ->label(__(self::$langFile.'.resources'))
                                                ->columnSpanFull(),

                                        ])->columns(3),
                                    Split::make([
                                        Fieldset::make(__(self::$langFile.'.religiosity_tab'))
                                            ->schema([
                                                TextEntry::make('religion.name')
                                                    ->label(__(self::$langFile.'.religion_id'))
                                                    ->columnSpanFull(),
                                                TextEntry::make('sect.name')
                                                    ->label(__(self::$langFile.'.sect_id'))
                                                    ->columnSpanFull(),
                                                TextEntry::make('religiosity.name')
                                                    ->label(__(self::$langFile.'.religiosity_id'))
                                                    ->columnSpanFull(),
                                            ]),
                                        Fieldset::make(__(self::$langFile.'.contact_tab'))
                                            ->schema([
                                                TextEntry::make('email')
                                                    ->label(__(self::$langFile.'.email'))
                                                    ->icon('heroicon-o-envelope')
                                                    ->hiddenLabel()
                                                    ->columnSpanFull(),
                                                TextEntry::make('mobile')
                                                    ->label(__(self::$langFile.'.mobile'))
                                                    ->icon('heroicon-o-device-phone-mobile')
                                                    ->hiddenLabel()
                                                    ->columnSpanFull(),
                                                TextEntry::make('address')
                                                    ->label(__(self::$langFile.'.address'))
                                                    ->columnSpanFull(),
                                            ]),
                                    ])->from('md')
                                        ->columnSpanFull(),

                                    Fieldset::make(__(self::$langFile.'.socials_tab'))
                                        ->schema([
                                            RepeatableEntry::make('socials')
                                                ->columnSpan(2)
                                                ->grid(4)
                                                ->hiddenLabel()
                                                ->schema([
                                                    TextEntry::make('types.name')
                                                        ->label(__(self::$langFile.'.social_types')),
                                                    TextEntry::make('link')
                                                        ->label(__(self::$langFile.'.link'))
                                                        ->url(static fn (Model $model): string => $model->link ?? '', shouldOpenInNewTab: true)
                                                        ->icon('heroicon-o-globe-alt'),
                                                    TextEntry::make('statuses.name')
                                                        ->label(__(self::$langFile.'.social_status')),

                                                    TextEntry::make('flower_count')
                                                        ->label(__(self::$langFile.'.flower_count')),
                                                    TextEntry::make('influenceLevel.name')
                                                        ->label(__(self::$langFile.'.influence_level_id')),

                                                ])->grow(false),
                                        ])->columnSpanFull(),

                                    Fieldset::make(__(self::$langFile.'.influences_tab'))
                                        ->schema([
                                            RepeatableEntry::make('influences')
                                                ->label(__(self::$langFile.'.influences_tab'))
                                                ->columnSpan(2)
                                                ->grid(3)
                                                ->hiddenLabel()
                                                ->schema([
                                                    TextEntry::make('social.name')
                                                        ->label(__(self::$langFile.'.social_types')),
                                                    TextEntry::make('flowers')
                                                        ->label(__(self::$langFile.'.flowers')),
                                                    TextEntry::make('viewers')
                                                        ->label(__(self::$langFile.'.viewers')),
                                                    TextEntry::make('likes')
                                                        ->label(__(self::$langFile.'.likes')),
                                                    TextEntry::make('comments')
                                                        ->label(__(self::$langFile.'.comments')),
                                                    TextEntry::make('influence_date')
                                                        ->label(__(self::$langFile.'.influence_date')),
                                                    TextEntry::make('event.title')
                                                        ->label(__(self::$langFile.'.event_id')),
                                                    TextEntry::make('influence_type.name')
                                                        ->label(__(self::$langFile.'.influence_type_id')),
                                                ])->columns(),
                                        ])->columnSpanFull(),
                                ]),
                            Tab::make(__(self::$langFile.'.experiences'))
                                ->schema([
                                    RelationManager::make()->manager(ExperiencesRelationManager::class)->lazy(false),
                                ]),
                            Tab::make(__(self::$langFile.'.professionals'))
                                ->schema([
                                    RelationManager::make()->manager(ProfessionalsRelationManager::class)->lazy(false),
                                ]),
                            Tab::make(__(self::$langFile.'.orientations'))
                                ->schema([
                                    RelationManager::make()->manager(OrientationsRelationManager::class)->lazy(false),
                                ]),
                            Tab::make(__(self::$langFile.'.facts'))
                                ->schema([
                                    RelationManager::make()->manager(FactsRelationManager::class)->lazy(false),
                                ]),
                            Tab::make(__(self::$langFile.'.dimensions'))
                                ->schema([
                                    RelationManager::make()->manager(DimensionsRelationManager::class)->lazy(false),
                                ]),
                            Tab::make(__(self::$langFile.'.issues_tab'))
                                ->schema([
                                    RelationManager::make()->manager(IssuesRelationManager::class)->lazy(false),
                                ]),
                            Tab::make(__(self::$langFile.'.logs'))
                                ->schema([
                                    RelationManager::make()->manager(LogsRelationManager::class)->lazy(false),
                                ]),
                        ]),
                ]),
            ]);
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}

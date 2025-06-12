<?php

namespace App\Filament\Resources;

use App\Filament\Exports\OrganizationExporter;
use App\Filament\Resources\OrganizationResource\Pages;
use App\Filament\Resources\OrganizationResource\RelationManagers\LogsRelationManager;
use App\Filament\Resources\OrganizationResource\RelationManagers\PeopleRelationManager;
use App\Models\Organization;
use Filament\Facades\Filament;
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
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Njxqlus\Filament\Components\Infolists\RelationManager;
use SolutionForest\FilamentTranslateField\Forms\Component\Translate;

class OrganizationResource extends Resource
{
    protected static ?string $model = Organization::class;

    protected static ?string $langFile = 'organization';

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Tabs')
                    ->columnSpanFull()
                    ->tabs([
                        Tabs\Tab::make(__(self::$langFile.'.personal_tab'))
                            ->schema([
                                \Filament\Forms\Components\Grid::make()
                                    ->hiddenLabel()
                                    ->schema([
                                        Translate::make()
                                            ->schema(fn (string $locale) => [
                                                TextInput::make('name')
                                                    ->required()
                                                    ->label(__(self::$langFile.'.name'))
                                                    ->maxLength(100)
                                                    ->required($locale == 'ar'),
                                            ])->locales(['ar', 'en']),
                                        \Filament\Forms\Components\Grid::make()
                                            ->schema([
                                                Select::make('type_id')
                                                    ->label(__(self::$langFile.'.type_id'))
                                                    ->relationship('organization_type', 'name')
                                                    ->required(),
                                                Select::make('organization_level_id')
                                                    ->label(__(self::$langFile.'.organization_level_id'))
                                                    ->relationship('organization_level', 'name')
                                                    ->required(),
                                                DatePicker::make('foundation_date')
                                                    ->label(__(self::$langFile.'.foundation_date'))
                                                    ->default(now()),
                                                Select::make('money_resource_id')
                                                    ->label(__(self::$langFile.'.money_resource_id'))
                                                    ->relationship('money_resource', 'name')
                                                    ->required(),
                                            ])->columns()
                                            ->columnSpan(2),
                                    ])->columns(3)
                                    ->columnSpanFull(),

                                Select::make('continent_id')
                                    ->label(__(self::$langFile.'.continent_id'))
                                    ->relationship('continent', 'name')
                                    ->required(),
                                Select::make('country_id')
                                    ->label(__(self::$langFile.'.country_id'))
                                    ->relationship('country', 'name')
                                    ->required(),
                                Select::make('city_id')
                                    ->label(__(self::$langFile.'.city_id'))
                                    ->relationship('city', 'name')
                                    ->required(),

                                Textarea::make('details')
                                    ->label(__(self::$langFile.'.details'))
                                    ->columnSpanFull(),
                                TextInput::make('website')
                                    ->label(__(self::$langFile.'.website'))
                                    ->url()
                                    ->maxLength(255)
                                    ->default(null),
                                Toggle::make('global_influencer')
                                    ->label(__(self::$langFile.'.global_influencer')),
                                Toggle::make('saudi_interested')
                                    ->label(__(self::$langFile.'.saudi_interested')),

                                //                                TextInput::make('boss')
                                //                                    ->label(__(self::$langFile.'.boss'))
                                //                                    ->maxLength(255)
                                //                                    ->default(null),

                                Select::make('status_id')
                                    ->relationship('organization_status', 'name')
                                    ->label(__(self::$langFile.'.organization_status')),

                                //                                Textarea::make('added_reason')
                                //                                    ->label(__(self::$langFile.'.added_reason')),
                                //                                Textarea::make('references')
                                //                                    ->label(__(self::$langFile.'.references')),

                                FileUpload::make('logo')
                                    ->label(__(self::$langFile.'.logo'))
                                    ->avatar(),

                                \Filament\Forms\Components\Fieldset::make(__(self::$langFile.'.boss'))->schema([
                                    Translate::make()
                                        ->schema(fn (string $locale) => [
                                            TextInput::make('boss')
                                                ->required()
                                                ->label(__(self::$langFile.'.boss'))
                                                ->maxLength(100)
                                                ->required($locale == 'ar'),
                                        ])->locales(['ar', 'en']),
                                    DatePicker::make('boss_join')
                                        ->label(__(self::$langFile.'.boss_join')),
                                    DatePicker::make('boss_leave')
                                        ->label(__(self::$langFile.'.boss_leave')),
                                ])->columns(3),
                                Textarea::make('resources')
                                    ->nullable()
                                    ->columnSpanFull()
                                    ->label(__(self::$langFile.'.resources')),

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
                                            ->relationship('influence_level', 'name')
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
                        Tabs\Tab::make(__(self::$langFile.'.dimensions'))
                            ->columns()
                            ->schema([
                                Repeater::make('dimensions')
                                    ->label(__(self::$langFile.'.dimensions'))
                                    ->relationship()
                                    ->columnSpan(2)
                                    ->columns()
                                    ->grid()
                                    ->schema([
                                        Select::make('dimension_id')
                                            ->relationship('dimension', 'name')
                                            ->required()
                                            ->label(__(self::$langFile.'.dimension_id')),
                                        Textarea::make('details')
                                            ->label(__(self::$langFile.'.details'))
                                            ->required(),

                                    ]),
                            ]),
                        \Filament\Forms\Components\Tabs\Tab::make(__('system.expire_date'))
                            ->schema([
                                DatePicker::make('expire_date')
                                    ->date()
                                    ->label(__('system.expire_date'))
                                    ->required()
                                    ->placeholder('YYYY-MM-DD')
                                    ->default(now())
                                    ->helperText(__('system.expire_date_hint')),
                            ])
                            ->columns(2),
                    ])->columns(3),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__(self::$langFile.'.name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('foundation_date')
                    ->label(__(self::$langFile.'.foundation_date'))
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('organization_type.name')
                    ->label(__(self::$langFile.'.type_id'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('continent.name')
                    ->label(__(self::$langFile.'.continent_id'))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('approval_status')
                    ->label(__('system.approval_status'))
                    ->formatStateUsing(fn($state) => __('system.approval_status_options.' . $state))
                    ->sortable()
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        'approved' => 'success',
                        'pending' => 'warning',
                        'reviewed' => 'info',
                        'rejected' => 'danger',
                        default => 'secondary',
                    })
                    ->toggleable()
                    ->alignCenter()
                    ->action(function ($record) {
                        if (auth()->user()?->hasRole('reviewer')) {
                            if ($record->approval_status === 'pending') {
                                $record->approval_status = 'reviewed';
                            } elseif ($record->approval_status === 'reviewed') {
                                $record->approval_status = 'pending';
                            }
                            $record->save();
                        } elseif (auth()->user()?->hasRole('approval')) {
                            if ($record->approval_status === 'reviewed') {
                                $record->approval_status = 'approved';
                            } elseif ($record->approval_status === 'approved') {
                                $record->approval_status = 'reviewed';
                            }
                            $record->save();
                        } elseif (auth()->user()?->hasRole('publisher') || auth()->user()?->hasRole('super_admin')) {
                            if ($record->approval_status === 'approved') {
                                $record->is_published = !$record->is_published;
                                $record->save();
                            }
                        }
                    }),
                Tables\Columns\BooleanColumn::make('is_published')
                    ->label(__('system.is_published'))
                    ->sortable()
                    ->toggleable()
                    ->alignCenter()
                    ->trueIcon('heroicon-o-check')
                    ->falseIcon('heroicon-o-x-mark')
                    ->action(function ($record) {
                        if (auth()->user()?->hasRole('publisher') || auth()->user()?->hasRole('super_admin')) {
                            $record->is_published = !$record->is_published;
                            $record->save();
                        }
                    }),
                Tables\Columns\TextColumn::make('country.name')
                    ->label(__(self::$langFile.'.country_id'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('money_resource.name')
                    ->label(__(self::$langFile.'.money_resource'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('boss')
                    ->label(__(self::$langFile.'.boss'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('organization_status.name')
                    ->label(__(self::$langFile.'.organization_status'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->label(__(self::$langFile.'.email'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('mobile')
                    ->label(__(self::$langFile.'.mobile'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__(self::$langFile.'.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                Tables\Filters\SelectFilter::make('approval_status')
                    ->options([
                        'pending' => __('system.approval_status_options.pending'),
                        'reviewed' => __('system.approval_status_options.reviewed'),
                        'approved' => __('system.approval_status_options.approved'),
                        'rejected' => __('system.approval_status_options.rejected'),
                    ])
                    ->label(__('system.approval_status')),
                Tables\Filters\SelectFilter::make('is_published')
                    ->options([
                        '1' => __('system.is_published_yes'),
                        '0' => __('system.is_published_no'),
                    ])
                    ->label(__('system.is_published')),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->headerActions([
                Tables\Actions\ExportAction::make()
                    ->exporter(OrganizationExporter::class)
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
                Tables\Actions\ExportBulkAction::class::make()
                    ->exporter(OrganizationExporter::class)
            ]);
    }

    public static function getRelations(): array
    {
        return [
            PeopleRelationManager::class,
            LogsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrganizations::route('/'),
            'create' => Pages\CreateOrganization::route('/create'),
            'view' => Pages\ViewOrganization::route('/{record}'),
            'edit' => Pages\EditOrganization::route('/{record}/edit'),
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
                            ->url(route('filament.admin.resources.organizations.edit', ['record' => $infolist->record])),
                    ])->alignEnd()
                        ->columnSpanFull(),
                    ImageEntry::make('logo')->circular()
                        ->hiddenLabel()
                        ->alignCenter(),
                    TextEntry::make('name')
                        ->weight(FontWeight::Bold)
                        ->hiddenLabel()
                        ->alignCenter(),
                    Grid::make()
                        ->columns(6)
                        ->schema([
                            TextEntry::make('continent.name')
                                ->icon('heroicon-o-globe-alt')
                                ->hiddenLabel()
                                ->alignEnd()
                                ->columnSpan(2),
                            TextEntry::make('country.name')
                                ->hiddenLabel()
                                ->icon('heroicon-o-flag')
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
                                    Split::make([
                                        Fieldset::make(__(self::$langFile.'.personal_tab'))
                                            ->schema([

                                                TextEntry::make('organization_type.name')
                                                    ->label(__(self::$langFile.'.type_id')),
                                                TextEntry::make('organization_level.name')
                                                    ->label(__(self::$langFile.'.organization_level_id')),

                                                TextEntry::make('foundation_date')
                                                    ->label(__(self::$langFile.'.foundation_date')),
                                                TextEntry::make('money_resource.name')
                                                    ->label(__(self::$langFile.'.money_resource')),

                                                TextEntry::make('country.name')
                                                    ->label(__(self::$langFile.'.country_id')),

                                                TextEntry::make('city.name')
                                                    ->label(__(self::$langFile.'.city_id')),

                                                IconEntry::make('global_influencer')
                                                    ->boolean()
                                                    ->label(__(self::$langFile.'.global_influencer')),
                                                IconEntry::make('saudi_interested')
                                                    ->boolean()
                                                    ->label(__(self::$langFile.'.saudi_interested')),

                                                TextEntry::make('organization_status.name')
                                                    ->label(__(self::$langFile.'.organization_status')),

                                                Fieldset::make(__(self::$langFile.'.boss'))
                                                    ->schema([
                                                        TextEntry::make('boss')
                                                            ->label(__(self::$langFile.'.boss')),
                                                        TextEntry::make('boss_join')
                                                            ->label(__(self::$langFile.'.boss_join')),
                                                        TextEntry::make('boss_leave')
                                                            ->label(__(self::$langFile.'.boss_leave')),
                                                    ])->columnSpanFull()
                                                    ->columns(3),

                                                TextEntry::make('details')
                                                    ->label(__(self::$langFile.'.details'))->columnSpanFull(),
                                                TextEntry::make('resources')
                                                    ->label(__(self::$langFile.'.resources'))->columnSpanFull(),

                                            ])->columns(3),
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
                                                TextEntry::make('website')
                                                    ->hiddenLabel()
                                                    ->label(__(self::$langFile.'.website'))
                                                    ->url(static fn (Model $model): string => $model->website ?? '', shouldOpenInNewTab: true)
                                                    ->icon('heroicon-o-globe-alt'),

                                                TextEntry::make('address')
                                                    ->label(__(self::$langFile.'.address'))
                                                    ->columnSpanFull(),
                                            ])->grow(false),
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
                                                    TextEntry::make('influence_level.name')
                                                        ->label(__(self::$langFile.'.influence_level_id')),

                                                ])->grow(false),
                                        ])->columnSpanFull(),
                                ]),
                            Tab::make(__(self::$langFile.'.peoples'))
                                ->schema([
                                    RelationManager::make()->manager(PeopleRelationManager::class)->lazy(false),
                                ]),
                            Tab::make(__(self::$langFile.'.influences_tab'))
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
                                ]),
                            Tab::make(__(self::$langFile.'.dimensions'))
                                ->schema([
                                    RepeatableEntry::make('dimensions')
                                        ->label(__(self::$langFile.'.dimensions'))
                                        ->columnSpan(2)
                                        ->grid(3)
                                        ->hiddenLabel()
                                        ->schema([
                                            TextEntry::make('dimension.name')
                                                ->label(__(self::$langFile.'.dimension_id'))
                                                ->columnSpanFull(),
                                            TextEntry::make('details')
                                                ->label(__(self::$langFile.'.details'))
                                                ->columnSpanFull(),
                                        ]),
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

    public static function canAccess(): bool
    {
        $user = Filament::auth()->user();

        return $user && method_exists($user, 'hasRole') && $user->hasRole('super_admin');
    }
}

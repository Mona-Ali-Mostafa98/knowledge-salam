<?php

namespace App\Filament\Resources;

use App\Enum\ConstantsTypes;
use App\Filament\Exports\EventExporter;
use App\Filament\Resources\EventResource\Pages;
use App\Models\City;
use App\Models\Constant;
use App\Models\Country;
use App\Models\Event;
use App\Models\Person;
use App\Models\Issues;
use App\Models\Organization;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\View;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use SolutionForest\FilamentTranslateField\Forms\Component\Translate;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $langFile = 'system';

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?int $navigationSort = 3;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label(__(self::$langFile . '.title'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_user.name')
                    ->label(__(self::$langFile . '.created_by'))
                    ->badge()
                    ->color('primary')
                    ->sortable(),
                Tables\Columns\TextColumn::make('event_date')
                    ->label(__(self::$langFile . '.event_date'))
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sector.name')
                    ->label(__(self::$langFile . '.sector_id'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('country.name')
                    ->label(__(self::$langFile . '.country_id'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('city.name')
                    ->label(__(self::$langFile . '.city_id'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('event_type')
                    ->label(__(self::$langFile . '.event_type'))
                    ->sortable()
                    ->formatStateUsing(fn($state) => __(self::$langFile . '.event_type_options.' . $state)),
                Tables\Columns\TextColumn::make('event_status')
                    ->label(__(self::$langFile . '.event_status'))
                    ->sortable()
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        'scheduled' => 'success',
                        'ongoing' => 'warning',
                        'completed' => 'info',
                        'cancelled' => 'danger',
                        default => 'secondary',
                    })
                    ->formatStateUsing(fn($state) => __(self::$langFile . '.event_status_options.' . $state))
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('approval_status')
                    ->label(__(self::$langFile . '.approval_status'))
                    ->formatStateUsing(fn($state) => __(self::$langFile . '.approval_status_options.' . $state))
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
                    ->alignCenter(),
                Tables\Columns\BooleanColumn::make('is_published')
                    ->label(__(self::$langFile . '.is_published'))
                    ->sortable()
                    ->toggleable()
                    ->alignCenter()
                    ->trueIcon('heroicon-o-check')
                    ->falseIcon('heroicon-o-x-mark'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__(self::$langFile . '.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                Tables\Filters\SelectFilter::make('approval_status')
                    ->options([
                        'pending' => __(self::$langFile . '.approval_status_options.pending'),
                        'reviewed' => __(self::$langFile . '.approval_status_options.reviewed'),
                        'approved' => __(self::$langFile . '.approval_status_options.approved'),
                        'rejected' => __(self::$langFile . '.approval_status_options.rejected'),
                    ])
                    ->label(__(self::$langFile . '.approval_status')),
                Tables\Filters\SelectFilter::make('is_published')
                    ->options([
                        '1' => __(self::$langFile . '.is_published_yes'),
                        '0' => __(self::$langFile . '.is_published_no'),
                    ])
                    ->label(__(self::$langFile . '.is_published')),
                Tables\Filters\SelectFilter::make('event_type')
                    ->options([
                        'article' => __(self::$langFile . '.event_type_options.article'),
                        'tweet' => __(self::$langFile . '.event_type_options.tweet'),
                        'video' => __(self::$langFile . '.event_type_options.video'),
                        'report' => __(self::$langFile . '.event_type_options.report'),
                        'conference' => __(self::$langFile . '.event_type_options.conference'),
                        'workshop' => __(self::$langFile . '.event_type_options.workshop'),
                        'meeting' => __(self::$langFile . '.event_type_options.meeting'),
                        'seminar' => __(self::$langFile . '.event_type_options.seminar'),
                        'press_release' => __(self::$langFile . '.event_type_options.press_release'),
                        'interview' => __(self::$langFile . '.event_type_options.interview'),
                        'publication' => __(self::$langFile . '.event_type_options.publication'),
                        'announcement' => __(self::$langFile . '.event_type_options.announcement'),
                        'webinar' => __(self::$langFile . '.event_type_options.webinar'),
                        'panel_discussion' => __(self::$langFile . '.event_type_options.panel_discussion'),
                    ])
                    ->label(__(self::$langFile . '.event_type')),
                Tables\Filters\SelectFilter::make('event_status')
                    ->options([
                        'scheduled' => __(self::$langFile . '.event_status_options.scheduled'),
                        'ongoing' => __(self::$langFile . '.event_status_options.ongoing'),
                        'completed' => __(self::$langFile . '.event_status_options.completed'),
                        'cancelled' => __(self::$langFile . '.event_status_options.cancelled'),
                    ])
                    ->label(__(self::$langFile . '.event_status')),
            ])
            ->actions([
                Tables\Actions\Action::make('changeApprovalStatus')
                    ->label(__(self::$langFile . '.change_status'))
                    ->icon('heroicon-o-adjustments-horizontal')
                    ->color('primary')
                    ->modalHeading(__(self::$langFile . '.change_request_status_and_publish'))
                    ->modalSubheading(fn($record) => __(self::$langFile . '.event_title') . ' : ' . ($record?->title ?: __('(No Title)')))
                    ->form([
                        Forms\Components\Select::make('approval_status')
                            ->label(__(self::$langFile . '.approval_status'))
                            ->helperText(__(self::$langFile . '.choose_status_by_role'))
                            ->default(fn($record) => $record?->approval_status)
                            ->options(function () {
                                $user = auth()->user();
                                if ($user->hasRole('reviewer')) {
                                    return [
                                        'pending' => __(self::$langFile . '.approval_status_options_detailed.pending'),
                                        'reviewed' => __(self::$langFile . '.approval_status_options_detailed.reviewed'),
                                    ];
                                }

                                if ($user->hasRole('approval')) {
                                    return [
                                        'reviewed' => __(self::$langFile . '.approval_status_options_detailed.reviewed'),
                                        'approved' => __(self::$langFile . '.approval_status_options_detailed.approved'),
                                    ];
                                }

                                if ($user->hasRole('publisher') || $user->hasRole('super_admin')) {
                                    return [
                                        'pending' => __(self::$langFile . '.approval_status_options_detailed.pending'),
                                        'reviewed' => __(self::$langFile . '.approval_status_options_detailed.reviewed'),
                                        'approved' => __(self::$langFile . '.approval_status_options_detailed.approved'),
                                        'rejected' => __(self::$langFile . '.approval_status_options_detailed.rejected'),
                                    ];
                                }

                                return [];
                            })
                            ->required(),
                        Forms\Components\Checkbox::make('is_published')
                            ->label(__('نشر/إلغاء النشر في النظام'))
                            ->helperText(__(self::$langFile . '.publish_helper_text'))
                            ->default(fn($record) => $record?->is_published)
                            ->visible(fn($get, $record) => (auth()->user()?->hasRole('publisher') || auth()->user()?->hasRole('super_admin')) &&
                                (($get('approval_status') ?? $record?->approval_status) === 'approved')
                            ),
                    ])
                    ->action(function (array $data, $record) {
                        $record->update([
                            'approval_status' => $data['approval_status'],
                        ]);
                        if (auth()->user()?->hasRole('publisher') || auth()->user()?->hasRole('super_admin') && isset($data['is_published'])) {
                            $record->is_published = $data['is_published'] ? 1 : 0;
                            $record->save();
                        }
                    })
                    ->visible(fn($record) => auth()->user()?->hasAnyRole(['reviewer', 'approval', 'publisher', 'super_admin'])),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()->visible(fn($record) => auth()->user()?->hasAnyRole(['super_admin']))

            ])
            ->headerActions([
                Tables\Actions\ExportAction::make()
                    ->exporter(EventExporter::class)
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
                Tables\Actions\ExportBulkAction::class::make()
                    ->exporter(EventExporter::class)
            ]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Event Tabs')
                    ->tabs([
                        Tab::make(__(self::$langFile . '.title_and_details'))
                            ->schema([
                                Translate::make()
                                    ->schema(fn(string $locale) => [
                                        TextInput::make('title')
                                            ->required()
                                            ->label(__(self::$langFile . '.title'))
                                            ->maxLength(100)
                                            ->required($locale == 'ar'),
                                    ])
                                    ->locales(['ar', 'en'])
                                    ->columnSpanFull(),
                                Translate::make()
                                    ->schema(fn(string $locale) => [
                                        Textarea::make('details')
                                            ->label(__(self::$langFile . '.details'))
                                            ->columnSpanFull()
                                            ->required($locale == 'ar'),
                                    ])
                                    ->locales(['ar', 'en'])
                                    ->columnSpanFull(),
                            ]),

                        Tab::make(__(self::$langFile . '.general_information'))
                            ->schema([
                                DatePicker::make('event_date')
                                    ->label(__(self::$langFile . '.event_date'))
                                    ->required()
                                    ->placeholder('YYYY-MM-DD')
                                    ->default(now()),
                                TimePicker::make('event_time')
                                    ->label(__(self::$langFile . '.event_time'))
                                    ->placeholder('HH:MM')
                                    ->withoutSeconds()
                                    ->default(now()->format('H:i')),

                                TextInput::make('url')
                                    ->nullable()
                                    ->label(__(self::$langFile . '.url')),
                                Select::make('event_status')
                                    ->options([
                                        'scheduled' => __(self::$langFile . '.event_status_options.scheduled'),
                                        'ongoing' => __(self::$langFile . '.event_status_options.ongoing'),
                                        'completed' => __(self::$langFile . '.event_status_options.completed'),
                                        'cancelled' => __(self::$langFile . '.event_status_options.cancelled')
                                    ])
                                    ->default('scheduled')
                                    ->label(__(self::$langFile . '.event_status')),

                                Select::make('sector_id')
                                    ->relationship('sector', 'name')
                                    ->label(__(self::$langFile . '.sector_id')),
                                Select::make('position_type_id')
                                    ->relationship('position_type', 'name')
                                    ->label(__(self::$langFile . '.position_type_id')),
                                Forms\Components\FileUpload::make('attachments')
                                    ->label(__(self::$langFile . '.attachments'))
                                    ->default(null),
                            ])->columns(),

                        Tab::make(__(self::$langFile . '.address'))
                            ->schema([
                                Select::make('continent_id')
                                    ->label(__(self::$langFile . '.continent_id'))
                                    ->relationship('continent', 'name')
                                    ->required(),
                                Select::make('country_id')
                                    ->relationship('country', 'name')
                                    ->label(__(self::$langFile . '.country_id')),
                                Select::make('city_id')
                                    ->relationship('city', 'name')
                                    ->label(__(self::$langFile . '.city_id')),
                                TextInput::make('venue') // new
                                ->label(__(self::$langFile . '.venue'))
                                    ->maxLength(100)
                                    ->columnSpanFull(),
                                Forms\Components\Hidden::make('latitude')
                                    ->required(),
                                Forms\Components\Hidden::make('longitude')
                                    ->required(),
                                View::make('filament.pages.map')
                                    ->label('Select Location from Map')
                                    ->columnSpanFull(),
                            ])->columns(),

                        Tab::make(__(self::$langFile . '.event_type'))
                            ->schema([
                                Select::make('event_type') // new
                                ->options([
                                    'article' => __(self::$langFile . '.event_type_options.article'),
                                    'report' => __(self::$langFile . '.event_type_options.report'),
                                    'tweet' => __(self::$langFile . '.event_type_options.tweet'),
                                    'video' => __(self::$langFile . '.event_type_options.video'),
                                    'conference' => __(self::$langFile . '.event_type_options.conference'),
                                    'workshop' => __(self::$langFile . '.event_type_options.workshop'),
                                    'meeting' => __(self::$langFile . '.event_type_options.meeting'),
                                    'seminar' => __(self::$langFile . '.event_type_options.seminar'),
                                    'press_release' => __(self::$langFile . '.event_type_options.press_release'),
                                    'interview' => __(self::$langFile . '.event_type_options.interview'),
                                    'publication' => __(self::$langFile . '.event_type_options.publication'),
                                    'announcement' => __(self::$langFile . '.event_type_options.announcement'),
                                    'webinar' => __(self::$langFile . '.event_type_options.webinar'),
                                    'panel_discussion' => __(self::$langFile . '.event_type_options.panel_discussion'),
                                ])
                                    ->label(__(self::$langFile . '.event_type'))
                                    ->columns(1)
                                    ->reactive(),
                                Forms\Components\Fieldset::make(__(self::$langFile . '.report_or_articles_data'))
                                    ->relationship('articleOrReportData')
                                    ->schema([
                                        Forms\Components\TextInput::make('publish_institution')
                                            ->label(__(self::$langFile . '.publish_institution'))
                                            ->maxLength(255)
                                            ->default(null),
                                        Forms\Components\Select::make('publish_institution_type_id')
                                            ->label(__(self::$langFile . '.publish_institution_type_id'))
                                            ->options(Constant::where('type', ConstantsTypes::InstitutionTypes->value)->pluck('name', 'id'))
                                            ->required(),

                                        Forms\Components\Fieldset::make(__(self::$langFile . '.countries_and_cities'))
                                            ->schema([
                                                Select::make('cities')
                                                    ->label(__(self::$langFile . '.city_id'))
                                                    ->options(City::pluck('name', 'id'))
                                                    ->multiple()
                                                    ->required(),
                                                Select::make('countries')
                                                    ->label(__(self::$langFile . '.interested_countries'))
                                                    ->options(Country::pluck('name', 'id'))
                                                    ->multiple()
                                                    ->required(),
                                            ]),

                                        Select::make('language_id')
                                            ->label(__(self::$langFile . '.language_id'))
                                            ->options(Constant::where('type', ConstantsTypes::Languages->value)->pluck('name', 'id'))
                                            ->required(),
                                        Forms\Components\Select::make('report_direction_id')
                                            ->label(__(self::$langFile . '.report_direction_id'))
                                            ->options(Constant::where('type', ConstantsTypes::ReportDirections->value)->pluck('name', 'id'))
                                            ->required(),
                                        Forms\Components\Select::make('added_reason_id')
                                            ->label(__(self::$langFile . '.added_reason_id'))
                                            ->options(Constant::where('type', ConstantsTypes::AddedReasons->value)->pluck('name', 'id'))
                                            ->required(),

                                        Forms\Components\Select::make('repetition_id')
                                            ->label(__(self::$langFile . '.repetition_id'))
                                            ->options(Constant::where('type', ConstantsTypes::Repetitions->value)->pluck('name', 'id'))
                                            ->required(),
                                        Forms\Components\Select::make('saudi_issue_direction_id')
                                            ->label(__(self::$langFile . '.saudi_issue_direction_id'))
                                            ->options(Constant::where('type', ConstantsTypes::SaudiIssueDirection->value)->pluck('name', 'id'))
                                            ->required(),

                                        Forms\Components\Fieldset::make(__(self::$langFile . '.dimension'))
                                            ->schema([
                                                Forms\Components\Select::make('dimension_id')
                                                    ->label(__(self::$langFile . '.dimension_id'))
                                                    ->options(Constant::where('type', ConstantsTypes::Dimensions->value)->pluck('name', 'id'))
                                                    ->required(),
                                                Forms\Components\Textarea::make('dimension_text')
                                                    ->label(__(self::$langFile . '.dimension_text'))
                                                    ->maxLength(255)
                                                    ->default(null)
                                                    ->columnSpanFull(),
                                            ]),
                                        Forms\Components\Fieldset::make(__(self::$langFile . '.contributions'))
                                            ->schema([
                                                Forms\Components\Select::make('contribution_type_id')
                                                    ->label(__(self::$langFile . '.contribution_type_id'))
                                                    ->options(Constant::where('type', ConstantsTypes::ContributionType->value)->pluck('name', 'id'))
                                                    ->required(),

                                                Translate::make()
                                                    ->schema(fn(string $locale) => [
                                                        TextInput::make('contribution_name')
                                                            ->label(__(self::$langFile . '.contribution_name'))
                                                            ->maxLength(255)
                                                            ->required($locale == 'ar')

                                                    ])
                                                    ->locales(['ar', 'en'])

                                                    ->columnSpanFull(),


                                                Forms\Components\Select::make('organizations_role_id')
                                                    ->label(__(self::$langFile . '.organizations_role_id'))
                                                    ->options(Constant::where('type', ConstantsTypes::OrganizationsRoles->value)->pluck('name', 'id'))
                                                    ->required(),
                                                Forms\Components\Select::make('contribution_role_id')
                                                    ->label(__(self::$langFile . '.contribution_role_id'))
                                                    ->options(Constant::where('type', ConstantsTypes::ContributionRoles->value)->pluck('name', 'id'))
                                                    ->required(),
                                            ]),
                                    ])->columns(2)
                                    ->visible(fn($get) => in_array($get('event_type'), ['article', 'report']))
                            ])->columns(2),

                        Tab::make(__(self::$langFile . '.peoples'))
                            ->schema([
                                Repeater::make('peoplePositionsOnIssues') // this must match the hasMany relation name
                                ->relationship('peoplePositionsOnIssues')
                                    ->label(__(self::$langFile . '.event_peoples'))
                                    ->schema([
                                        Select::make('person_id')
                                            // ->relationship('peoples', 'id')
                                            ->label(__(self::$langFile . '.event_peoples'))
                                            ->searchable(['first_name', 'mid_name', 'last_name'])
                                            ->getOptionLabelFromRecordUsing(
                                                fn(Person $record) => trim("{$record->first_name} {$record->mid_name} {$record->last_name}") ?: '-'
                                            )
                                            ->relationship('person', 'first_name') // binds to `person()` relation in pivot model
                                            ->required(),

                                        Select::make('issue_id')
                                            ->label(__(self::$langFile . '.event_issues'))
                                            ->searchable()
                                            ->getOptionLabelFromRecordUsing(
                                                fn(Issues $record) => $record->issue_name ?? '-'
                                            )
                                            ->relationship('issue', 'issue_name') // binds to `issue()` relation in pivot model
                                            ->required()
                                            ->createOptionForm([
                                                TextInput::make('issue_name')
                                                    ->label(__('system.issue_name'))
                                                    ->required()
                                                    ->maxLength(255),
                                            ])
                                            ->createOptionAction(function ($action) {
                                                return $action->modalHeading(__('Add New Issue'));
                                            }),


                                        Select::make('person_direction_id')
                                            ->relationship('person_direction', 'name')
                                            ->label(__(self::$langFile . '.person_direction_id')),

                                        Textarea::make('person_position')
                                            ->label(__(self::$langFile . '.person_position'))
                                            ->nullable()
                                            ->columnSpanFull(),
                                    ])
                                    ->addActionLabel(__(self::$langFile . '.add_position'))
                                    ->columns(3)
                                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                        $combinations = [];
                                        foreach ($state as $index => $item) {
                                            $key = ($item['person_id'] ?? null) . '-' . ($item['issue_id'] ?? null);
                                            if (isset($combinations[$key])) {
                                                // Set error on the duplicate row
                                                $set("peoplePositionsOnIssues.{$index}.issue_id", null);
                                                Notification::make()
                                                    ->title(__(self::$langFile . '.Duplicate_person_and_issue'))
                                                    ->danger()
                                                    ->send();
                                            }
                                            $combinations[$key] = true;
                                        }
                                    }),
                            ]),

                        Tab::make(__(self::$langFile . '.organizations'))
                            ->schema([
                                Repeater::make('organizationPositionsOnIssues')
                                    ->relationship('organizationPositionsOnIssues')
                                    ->label(__(self::$langFile . '.event_organizations'))
                                    ->schema([
                                        Select::make('organization_id')
                                            ->label(__(self::$langFile . '.organization_id'))
                                            ->searchable()
                                            ->getOptionLabelFromRecordUsing(
                                                fn(Organization $record) => "{$record->name}"
                                            )
                                            ->relationship('organization', 'name')
                                            ->required(),

                                        Select::make('issue_id')
                                            ->label(__(self::$langFile . '.event_issues'))
                                            ->searchable()
                                            ->getOptionLabelFromRecordUsing(
                                                fn(Issues $record) => $record->issue_name ?? '-'
                                            )
                                            ->relationship('issue', 'issue_name') // binds to `issue()` relation in pivot model
                                            ->required()
                                            ->createOptionForm([
                                                TextInput::make('issue_name')
                                                    ->label(__('system.issue_name'))
                                                    ->required()
                                                    ->maxLength(255),
                                            ])
                                            ->createOptionAction(function ($action) {
                                                return $action->modalHeading(__('Add New Issue'));
                                            }),

                                        Select::make('organization_role_id')
                                            ->relationship('organization_role', 'name')
                                            ->label(__(self::$langFile . '.organization_role_id')),

                                        Select::make('organization_direction_id')
                                            ->relationship('organization_direction', 'name')
                                            ->label(__(self::$langFile . '.organization_direction_id')),

                                        Textarea::make('organization_position')
                                            ->label(__(self::$langFile . '.organization_position'))
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(3)
                                    ->addActionLabel(__(self::$langFile . '.add_position'))
                                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                        $combinations = [];
                                        foreach ($state as $index => $item) {
                                            $key = ($item['organization_id'] ?? null) . '-' . ($item['issue_id'] ?? null);
                                            if (isset($combinations[$key])) {
                                                // Set error on the duplicate row
                                                $set("organizationPositionsOnIssues.{$index}.issue_id", null);
                                                Notification::make()
                                                    ->title(__(self::$langFile . '.Duplicate_organization_and_issue'))
                                                    ->danger()
                                                    ->send();
                                            }
                                            $combinations[$key] = true;
                                        }
                                    }),
                            ]),

                        Tab::make(__(self::$langFile . '.issues_saudi_direction'))
                            ->schema([

                                Select::make('saudi_direction_id')
                                    ->relationship('saudi_direction', 'name')
                                    ->label(__(self::$langFile . '.saudi_direction_id')),
                                Textarea::make('saudi_direction')
                                    ->label(__(self::$langFile . '.saudi_direction'))
                                    ->rows(2)
                                    ->columnSpanFull(),
                            ])->columns(),

                        Tab::make(__(self::$langFile . '.tags'))
                            ->schema([
                                TagsInput::make('tags')
                                    ->separator(',')
                                    ->label(__(self::$langFile . '.tags'))
                                    ->columnSpanFull()
                            ]),

                        Tab::make(__(self::$langFile . '.expire_date'))
                            ->schema([
                                DatePicker::make('expire_date')
                                    ->date()
                                    ->label(__(self::$langFile . '.expire_date'))
                                    ->required()
                                    ->placeholder('YYYY-MM-DD')
                                    ->default(now())
                                    ->helperText(__(self::$langFile . '.expire_date_hint')),
                            ])
                            ->columns(2),

                        ...(
                        auth()->user()?->hasRole('super_admin')
                            ? [
                            Tab::make(__(self::$langFile . '.approval_status'))
                                ->schema([
                                    Select::make('approval_status')
                                        ->label(__(self::$langFile . '.approval_status'))
                                        ->default(fn($record) => $record?->approval_status ?: 'pending')
                                        ->options([
                                            'pending' => __(self::$langFile . '.approval_status_options.pending'),
                                            'reviewed' => __(self::$langFile . '.approval_status_options.reviewed'),
                                            'approved' => __(self::$langFile . '.approval_status_options.approved'),
                                            'rejected' => __(self::$langFile . '.approval_status_options.rejected'),
                                        ])
                                        ->reactive()
                                        ->afterStateUpdated(function ($state, callable $set) {
                                            if ($state === 'approved') {
                                                $set('publish_date', now());
                                            } else {
                                                $set('publish_date', null);
                                            }
                                        })
                                        ->disableOptionWhen(fn(string $value, $record) => $value === 'super_admin' && !$record->hasRole('super_admin'), merge: true),
                                ])->columns(),
                        ] : []),
                    ])
                    ->columnSpanFull(),
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
            'view' => Pages\ViewEvent::route('/{record}'),
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
        return __(self::$langFile . '.events');
    }

    public static function getLabel(): ?string
    {
        return __(self::$langFile . '.event');
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

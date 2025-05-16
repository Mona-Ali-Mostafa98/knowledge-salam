<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SaudiArticlesResource\Pages;
use App\Models\City;
use App\Models\Country;
use App\Models\SaudiArticles;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use SolutionForest\FilamentTranslateField\Forms\Component\Translate;

class SaudiArticlesResource extends Resource
{
    protected static ?string $model = SaudiArticles::class;

    protected static ?string $langFile = 'system';

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make([
                    Forms\Components\Select::make('article_type_id')
                        ->label(__(self::$langFile.'.article_type_id'))
                        ->relationship('article_type', 'name')
                        ->required(),
                    //                    Forms\Components\Select::make('source_location_id')
                    //                        ->label(__(self::$langFile.'.source_location_id'))
                    //                        ->relationship('source_location', 'name')
                    //                        ->required(),

                    Translate::make()
                        ->schema(fn (string $locale) => [
                            TextInput::make('title')
                                ->required()
                                ->label(__(self::$langFile.'.title'))
                                ->maxLength(255)
                                ->required($locale == 'ar'),
                        ])->locales(['ar', 'en'])
                        ->columnSpanFull(),

                    Forms\Components\Select::make('publish_institution_type_id')
                        ->label(__(self::$langFile.'.publish_institution_type_id'))
                        ->relationship('publish_institution_type', 'name')
                        ->required(),

                    Forms\Components\DateTimePicker::make('publish_date')
                        ->label(__(self::$langFile.'.publish_date'))
                        ->default(now()),
                    Forms\Components\TextInput::make('publish_institution')
                        ->label(__(self::$langFile.'.publish_institution'))
                        ->maxLength(255)
                        ->default(null),

                    //                    Forms\Components\Select::make('person_id')
                    //                        ->label(__(self::$langFile.'.person_id'))
                    //                        ->relationship(
                    //                            name: 'person',
                    //                            modifyQueryUsing: fn (Builder $query) => $query->orderBy('first_name')->orderBy('last_name'),
                    //                        )
                    //                        ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->first_name} {$record->mid_name} {$record->last_name}")
                    //                        ->required(),

                    Forms\Components\TextInput::make('link')
                        ->label(__(self::$langFile.'.link'))
                        ->url()
                        ->required()
                        ->maxLength(255),

                    Forms\Components\Textarea::make('details')
                        ->label(__(self::$langFile.'.article_details'))
                        ->maxLength(255)
                        ->default(null)
                        ->columnSpanFull(),

                    Select::make('continent_id')
                        ->label(__(self::$langFile.'.continent_id'))
                        ->relationship('continent', 'name')
                        ->required(),
                    Select::make('country_id')
                        ->label(__(self::$langFile.'.country_id'))
                        ->relationship('country', 'name')
                        ->required(),

                    Select::make('cities')
                        ->label(__(self::$langFile.'.city_id'))
                        ->options(City::pluck('name', 'id'))
                        ->multiple()
                        ->required(),

                    Select::make('countries')
                        ->label(__(self::$langFile.'.interested_countries'))
                        ->options(Country::pluck('name', 'id'))
                        ->multiple()
                        ->required(),

                    Select::make('language_id')
                        ->label(__(self::$langFile.'.language_id'))
                        ->relationship('language', 'name')
                        ->required(),
                    Forms\Components\TagsInput::make('tags')
                        ->separator(',')
                        ->label(__(self::$langFile.'.tags')),

                    Forms\Components\Select::make('report_direction_id')
                        ->label(__(self::$langFile.'.report_direction_id'))
                        ->relationship('report_direction', 'name')
                        ->required(),
                    Forms\Components\Select::make('added_reason_id')
                        ->label(__(self::$langFile.'.added_reason_id'))
                        ->relationship('added_reason', 'name')
                        ->required(),

                    Forms\Components\Select::make('repetition_id')
                        ->label(__(self::$langFile.'.repetition_id'))
                        ->relationship('repetition', 'name')
                        ->required(),
                    Forms\Components\Select::make('saudi_issue_direction_id')
                        ->label(__(self::$langFile.'.saudi_issue_direction_id'))
                        ->relationship('saudi_issue_direction', 'name')
                        ->required(),

                    Forms\Components\Fieldset::make(__(self::$langFile.'.dimension'))
                        ->schema([
                            Forms\Components\Select::make('dimension_id')
                                ->label(__(self::$langFile.'.dimension_id'))
                                ->relationship('dimension', 'name')
                                ->required(),
                            Forms\Components\Textarea::make('dimension_text')
                                ->label(__(self::$langFile.'.dimension_text'))
                                ->maxLength(255)
                                ->default(null)
                                ->columnSpanFull(),
                        ]),
                    Forms\Components\Fieldset::make(__(self::$langFile.'.contributions'))
                        ->schema([
                            Forms\Components\Select::make('contribution_type_id')
                                ->label(__(self::$langFile.'.contribution_type_id'))
                                ->relationship('contribution_type', 'name')
                                ->required(),

                            Translate::make()
                                ->schema(fn (string $locale) => [
                                    TextInput::make('contribution_name')
                                        ->required()
                                        ->label(__(self::$langFile.'.contribution_name'))
                                        ->maxLength(255)
                                        ->required($locale == 'ar'),
                                ])->locales(['ar', 'en'])
                                ->columnSpanFull(),

                            Forms\Components\Select::make('organizations_role_id')
                                ->label(__(self::$langFile.'.organizations_role_id'))
                                ->relationship('organizations_role', 'name')
                                ->required(),
                            Forms\Components\Select::make('contribution_role_id')
                                ->label(__(self::$langFile.'.contribution_role_id'))
                                ->relationship('contribution_role', 'name')
                                ->required(),
                        ]),

                    Forms\Components\FileUpload::make('attachments')
                        ->label(__(self::$langFile.'.attachments'))
                        ->default(null),
                ])->columns(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //                Tables\Columns\TextColumn::make('person.name')
                //                    ->label(__(self::$langFile.'.person_id'))
                //                    ->numeric()
                //                    ->sortable(),
                Tables\Columns\TextColumn::make('article_type.name')
                    ->label(__(self::$langFile.'.article_type_id'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->label(__(self::$langFile.'.title'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('publish_date')
                    ->label(__(self::$langFile.'.publish_date'))
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('publish_institution')
                    ->label(__(self::$langFile.'.publish_institution'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('report_direction.name')
                    ->label(__(self::$langFile.'.report_direction_id'))
                    ->searchable(),
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
            'index' => Pages\ListSaudiArticles::route('/'),
            'create' => Pages\CreateSaudiArticles::route('/create'),
            'edit' => Pages\EditSaudiArticles::route('/{record}/edit'),
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
        return __(self::$langFile.'.saudi_articles');
    }

    public static function getLabel(): ?string
    {
        return __(self::$langFile.'.saudi_article');
    }
}

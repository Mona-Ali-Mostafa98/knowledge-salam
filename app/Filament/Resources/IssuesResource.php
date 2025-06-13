<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IssuesResource\Pages;
use App\Models\Issues;
use Filament\Facades\Filament;
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

class IssuesResource extends Resource
{
    protected static ?string $model = Issues::class;

    protected static ?string $langFile = 'system';

    protected static ?string $navigationIcon = 'heroicon-o-inbox-stack';

    protected static ?int $navigationSort = 7;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make([
                    Translate::make()
                        ->schema(fn(string $locale) => [
                            TextInput::make('issue_name')
                                ->required()
                                ->label(__(self::$langFile . '.issue_name'))
                                ->maxLength(100)
                                ->required($locale == 'ar'),
                        ])
                        ->locales(['ar', 'en'])
                        ->columnSpanFull(),
                    Select::make('issue_type')
                        ->relationship('issueType', 'name')
                        ->label(__(self::$langFile . '.issue_type')),
                    Select::make('issue_field')
                        ->relationship('issueField', 'name')
                        ->label(__(self::$langFile . '.issue_field')),
                    Forms\Components\Textarea::make('saudi_direction')
                        ->label(__(self::$langFile.'.direction'))
                        ->required()
                        ->columnSpanFull(),
                    Forms\Components\Textarea::make('issue_description')
                        ->label(__(self::$langFile.'.issue_description'))
                        ->columnSpanFull(),
                ])->columns(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('issue_name')
                    ->label(__(self::$langFile.'.issue_name'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('issueType.name')
                    ->label(__(self::$langFile . '.issue_type'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('issueField.name')
                    ->label(__(self::$langFile . '.issue_field'))
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
                Tables\Filters\SelectFilter::make('issueType')
                    ->relationship('issueType', 'name')
                    ->label(__(self::$langFile . '.issue_type')),
                Tables\Filters\SelectFilter::make('issueField')
                    ->relationship('issueField', 'name')
                    ->label(__(self::$langFile . '.issue_field')),
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
            'index' => Pages\ListIssues::route('/'),
            'create' => Pages\CreateIssues::route('/create'),
            'edit' => Pages\EditIssues::route('/{record}/edit'),
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
        return __(self::$langFile.'.issues');
    }

    public static function getLabel(): ?string
    {
        return __(self::$langFile.'.issue');
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

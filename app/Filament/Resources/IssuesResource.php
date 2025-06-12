<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IssuesResource\Pages;
use App\Models\Issues;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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

                    Forms\Components\Select::make('issue_name_id')
                        ->label(__(self::$langFile.'.issue_name_id'))
                        ->relationship('issue_name', 'name'),

                    Forms\Components\Textarea::make('title')
                        ->label(__(self::$langFile.'.title'))
                        ->required()
                        ->columnSpanFull(),
                    Forms\Components\Textarea::make('direction')
                        ->label(__(self::$langFile.'.direction'))
                        ->required()
                        ->columnSpanFull(),
                    Forms\Components\Textarea::make('note')
                        ->label(__(self::$langFile.'.note'))
                        ->columnSpanFull(),
                    Forms\Components\Select::make('person_id')
                        ->relationship(
                            name: 'person',
                            modifyQueryUsing: fn (Builder $query) => $query->orderBy('first_name')->orderBy('last_name'),
                        )
                        ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->first_name} {$record->mid_name} {$record->last_name}")
                        ->label(__(self::$langFile.'.person_id'))
                        ->hint(__(self::$langFile.'.person_id_hint')),
                    Forms\Components\Select::make('organization_id')
                        ->relationship('organization', 'name')
                        ->label(__(self::$langFile.'.organization_id'))
                        ->hint(__(self::$langFile.'.organization_id_hint')),
                ])->columns(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label(__(self::$langFile.'.title'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('person.name')
                    ->label(__(self::$langFile.'.person_id'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('organization.name')
                    ->label(__(self::$langFile.'.organization_id'))
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

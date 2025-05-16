<?php

namespace App\Filament\Resources\OrganizationResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PeopleRelationManager extends RelationManager
{
    protected static string $relationship = 'people';

    protected static ?string $langFile = 'organization';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('person_id')
                    ->label(__(self::$langFile.'.person_id'))
                    ->relationship(
                        name: 'person',
                        modifyQueryUsing: fn (Builder $query) => $query->orderBy('first_name')->orderBy('last_name'),
                    )
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->first_name} {$record->mid_name} {$record->last_name}")
                    ->required(),
                Forms\Components\Select::make('role_id')
                    ->label(__(self::$langFile.'.role_id'))
                    ->relationship('organizations_role', 'name'),
                Forms\Components\DateTimePicker::make('register_date')
                    ->default(now())
                    ->label(__(self::$langFile.'.register_date')),
                Forms\Components\DateTimePicker::make('leave_date')
                    ->default(null)
                    ->label(__(self::$langFile.'.leave_date')),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('person.name')
                    ->label(__(self::$langFile.'.person_id')),
                Tables\Columns\TextColumn::make('organizations_role.name')
                    ->label(__(self::$langFile.'.role_id')),
                Tables\Columns\TextColumn::make('register_date')
                    ->label(__(self::$langFile.'.register_date')),
                Tables\Columns\TextColumn::make('leave_date')
                    ->label(__(self::$langFile.'.leave_date')),
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
        return __(self::$langFile.'.peoples');
    }

    public static function getModelLabel(): ?string
    {
        return __(self::$langFile.'.person');
    }
}

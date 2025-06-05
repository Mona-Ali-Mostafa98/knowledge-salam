<?php

namespace App\Filament\Resources;

use App\Filament\Exports\UserExporter;
use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use App\Notifications\UserUpdateStatusNotification;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $langFile = 'system';

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->label(__(self::$langFile . '.name'))
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->label(__(self::$langFile . '.email'))
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\DateTimePicker::make('email_verified_at')
                    ->label(__(self::$langFile . '.email_verified_at'))
                    ->default(now()),
                Forms\Components\TextInput::make('mobile')
                    ->label(__('person.mobile'))
                    ->tel()
                    ->maxLength(20)
                    ->rule('regex:/^[0-9+\-\s\(\)]+$/')
                    ->unique(User::class, 'mobile', ignoreRecord: true),
                Forms\Components\TextInput::make('password')
                    ->label(__(self::$langFile . '.password'))
                    ->required(fn(string $operation): bool => $operation === 'create')
                    ->password()
                    ->maxLength(255)
                    ->confirmed(),
                Forms\Components\TextInput::make('password_confirmation')
                    ->label(__('filament-panels::pages/auth/register.form.password_confirmation.label'))
                    ->password()
                    ->maxLength(255)
                    ->dehydrated(false),
                Forms\Components\TextInput::make('job_title')
                    ->label(__('person.job_title'))
                    ->maxLength(255),
                Forms\Components\TextInput::make('national_id')
                    ->label(__('person.national_id'))
                    ->maxLength(255),
                Forms\Components\Textarea::make('bio')
                    ->label(__('person.bio')),
                Forms\Components\Select::make('sector_id')
                    ->label(__(self::$langFile . '.sector_id'))
                    ->relationship('sector', 'name')
                    ->searchable(),
                Forms\Components\Select::make('organization_id')
                    ->label(__(self::$langFile . '.organization_id'))
                    ->relationship('organization', 'name')
                    ->searchable(),
                Forms\Components\Textarea::make('registration_purpose')
                    ->label(__('person.registration_purpose')),
                Forms\Components\FileUpload::make('identity_document')
                    ->label(__('person.identity_document')),
                Forms\Components\FileUpload::make('photo')
                    ->label(__('person.photo')),
                Forms\Components\Select::make('requested_role')
                    ->label(__(self::$langFile . '.requested_role'))
                    ->options([
                        'content_manager' => __(self::$langFile . '.requested_role_options.content_manager'),
                        'event_manager' => __(self::$langFile . '.requested_role_options.event_manager'),
                        'report_viewer' => __(self::$langFile . '.requested_role_options.report_viewer'),
                        'admin' => __(self::$langFile . '.requested_role_options.admin'),
                    ]),
                Forms\Components\Select::make('approval_status')
                    ->label(__(self::$langFile . '.approval_status'))
                    ->options([
                        'pending' => __(self::$langFile . '.approval_status_options.pending'),
                        'reviewed' => __(self::$langFile . '.approval_status_options.reviewed'),
                        'approved' => __(self::$langFile . '.approval_status_options.approved'),
                        'rejected' => __(self::$langFile . '.approval_status_options.rejected'),
                    ])
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        if ($state === 'approved') {
                            $set('approved_at', now());
                        } else {
                            $set('approved_at', null);
                        }
                    }),

                Forms\Components\DateTimePicker::make('approved_at')
                    ->label(__('person.approved_at'))
                    ->dehydrated(fn($get) => $get('approval_status') === 'approved')
                    ->disabled(fn($get) => $get('approval_status') !== 'approved')
                    ->reactive(),

                Forms\Components\Select::make('roles')
                    ->relationship('roles', 'name')
                    ->label(__(self::$langFile . '.roles'))
                    ->multiple()
                    ->preload()
                    ->searchable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo')
                    ->label(__('person.photo'))
                    ->defaultImageUrl(asset('images/salam.png'))
                    ->circular()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('name')
                    ->label(__(self::$langFile . '.name'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label(__(self::$langFile . '.email'))
                    ->sortable()
                    ->searchable(),

                ...(
                auth()->user()?->hasRole('super_admin')
                    ? [
                        Tables\Columns\SelectColumn::make('approval_status')
                            ->label(__(self::$langFile . '.approval_status'))
                            ->options([
                                'pending' => __(self::$langFile . '.approval_status_options.pending'),
                                'reviewed' => __(self::$langFile . '.approval_status_options.reviewed'),
                                'approved' => __(self::$langFile . '.approval_status_options.approved'),
                                'rejected' => __(self::$langFile . '.approval_status_options.rejected'),
                            ])
                            ->sortable()
                            ->toggleable()
                            ->extraAttributes([
                                'style' => 'max-width: 9rem !important',
                                'class' => 'min-w-[2rem] max-w-[4rem] whitespace-nowrap text-sm px-1 py-0.5',
                            ])
                            ->alignCenter()
                            ->afterStateUpdated(function ($record, $state) {
                                if ($state === 'approved') {
                                    $record->approved_at = now();
                                } else {
                                    $record->approved_at = null;
                                }
                                $record->save();
                                $record->notify(new UserUpdateStatusNotification($record));
                            })
                            ->disableOptionWhen(fn(string $value, $record) => $value === 'super_admin' && !$record->hasRole('super_admin'), merge: true),
                    ]
                    : [
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
                    ]
                ),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__(self::$langFile . '.created_at'))
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('approved_at')
                    ->label(__('person.approved_at'))
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                Tables\Filters\SelectFilter::make('approval_status')
                    ->label(__(self::$langFile . '.approval_status'))
                    ->options([
                        'pending' => __(self::$langFile . '.approval_status_options.pending'),
                        'reviewed' => __(self::$langFile . '.approval_status_options.reviewed'),
                        'approved' => __(self::$langFile . '.approval_status_options.approved'),
                        'rejected' => __(self::$langFile . '.approval_status_options.rejected'),
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->headerActions([
                Tables\Actions\ExportAction::make()
                    ->exporter(UserExporter::class)
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
                Tables\Actions\ExportBulkAction::class::make()
                    ->exporter(UserExporter::class)
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getNavigationGroup(): ?string
    {
        return __('filament-shield::filament-shield.nav.group');
    }

    public static function getPluralLabel(): ?string
    {
        return __(self::$langFile . '.users');
    }

    public static function getLabel(): ?string
    {
        return __(self::$langFile . '.user');
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}

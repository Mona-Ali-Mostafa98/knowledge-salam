<?php

namespace App\Filament\Helper;

use App\Enum\ConstantsTypes;
use App\Models\Constant;
use App\Models\Organization;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Pages\Auth\Register;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Components\Grid;
class CustomRegister extends Register
{
    protected static string $view = 'filament.pages.auth.register';

    protected static ?string $langFile = 'person';

    protected static ?string $model = User::class;

    public function form(Form $form): Form
    {
        return $form
        ->schema([
            Grid::make(2)
                ->schema([
                    $this->getNameFormComponent(),
                    $this->getEmailFormComponent(),
                    TextInput::make('mobile')
                        ->label(__(self::$langFile.'.mobile'))
                        ->tel()
                        ->required()
                        ->maxLength(20)
                        ->rule('regex:/^[0-9+\-\s\(\)]+$/')
                        ->unique($this->getUserModel()),
                    TextInput::make('job_title')
                        ->label(__(self::$langFile.'.job_title'))
                        ->required()
                        ->maxLength(20),
                    $this->getPasswordFormComponent(),
                    $this->getPasswordConfirmationFormComponent(),
                    TextInput::make('national_id')
                        ->label(__(self::$langFile.'.national_id'))
                        ->integer()
                        ->required(),
                    TextInput::make('registration_purpose')
                        ->label(__(self::$langFile.'.registration_purpose'))
                        ->required()
                        ->maxLength(20),
                    Select::make('organization_id')
                        ->options(Organization::pluck('name', 'id'))
                        ->nullable()
                        ->label(__(self::$langFile.'.organization_id')),
                    Select::make('sector_id')
                        ->options(Constant::where('type', ConstantsTypes::Sectors->value)
                            ->pluck('name', 'id'))
                        ->nullable()
                        ->label(__(self::$langFile.'.sector_id')),
                    Textarea::make('bio')
                        ->label(__(self::$langFile.'.bio'))
                        ->maxLength(1000)
                        ->rows(2),
                ]),
        ]);
    }

    protected function afterRegister(): void
    {
        Filament::auth()->logout();
        Notification::make()
            ->title(__('auth.Your account is pending approval.'))
            ->success()
            ->send();
    }

    protected function getRedirectUrl(): string
    {
        return route('filament.admin.auth.login');
    }
}

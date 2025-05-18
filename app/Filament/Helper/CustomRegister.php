<?php

namespace App\Filament\Helper;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Pages\Auth\Register;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;

class CustomRegister extends Register
{
    protected static string $view = 'filament.pages.auth.login-register-form';

    protected static ?string $langFile = 'person';
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->getNameFormComponent(),
                $this->getEmailFormComponent(),
                TextInput::make('mobile')
                    ->label('Mobile')
                    ->tel()
                    ->required()
                    ->maxLength(20)
                    ->unique($this->getUserModel()),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
                TextInput::make('job_title')
                    ->label(__(self::$langFile.'.job_title'))
                    ->required()
                    ->maxLength(20),
                TextInput::make('national_id')
                    ->label(__(self::$langFile.'.national_id'))
                    ->integer()
                    ->required(),
                Textarea::make('bio')
                    ->label(__(self::$langFile.'.bio'))
                    ->maxLength(1000)
                    ->rows(4),
                Select::make('organization_id')
                    ->nullable()
                    ->relationship('organization', 'name')
                    ->label(__(self::$langFile.'.organization_id')),
                Select::make('sector_id')
                    ->nullable()
                    ->relationship('sector', 'name')
                    ->label(__(self::$langFile.'.sector_id')),
                TextInput::make('registration_purpose')
                    ->label(__(self::$langFile.'.registration_purpose'))
                    ->required()
                    ->maxLength(20),
            ]);
    }

}

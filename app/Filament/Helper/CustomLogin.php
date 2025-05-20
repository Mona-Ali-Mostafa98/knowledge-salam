<?php

namespace App\Filament\Helper;

use Filament\Pages\Auth\Login;
use Filament\Forms\Form;

class CustomLogin extends Login
{
    protected static string $view = 'filament.pages.auth.login';

    public function form(Form $form): Form
    {
        return $form;
    }
}

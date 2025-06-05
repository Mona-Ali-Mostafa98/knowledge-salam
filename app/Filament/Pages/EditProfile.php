<?php

namespace App\Filament\Pages;

use App\Enum\ConstantsTypes;
use Exception;
use Filament\Actions\Action;
use Filament\Forms\Components\Grid;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Forms\Form;
use Filament\Facades\Filament;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rules\Password;
use Illuminate\Contracts\Auth\Authenticatable;
use Filament\Forms;

class EditProfile extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.edit-profile';
    protected static bool $shouldRegisterNavigation = false;

    public ?array $profileData = [];
    public ?array $passwordData = [];

    protected static ?string $langFile = 'person';

    public function mount(): void
    {
        $this->fillForms();
    }

    public function getTitle(): string
    {
        return __('person.profile.edit_profile');
    }

    protected function getForms(): array
    {
        return [
            'editProfileForm',
            'editPasswordForm',
        ];
    }

    public function editProfileForm(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label(__('person.profile.fields.name'))
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->label(__('person.profile.fields.email'))
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        Forms\Components\TextInput::make('mobile')
                            ->label(__(self::$langFile . '.mobile'))
                            ->tel()
                            ->required()
                            ->maxLength(20)
                            ->rule('regex:/^[0-9+\-\s\(\)]+$/')
                            ->unique(ignoreRecord: true),
                        Forms\Components\TextInput::make('job_title')
                            ->label(__(self::$langFile . '.job_title'))
                            ->required()
                            ->maxLength(20),
                        Forms\Components\TextInput::make('national_id')
                            ->label(__(self::$langFile . '.national_id'))
                            ->integer()
                            ->required(),
                        Forms\Components\TextInput::make('registration_purpose')
                            ->label(__(self::$langFile . '.registration_purpose'))
                            ->required()
                            ->maxLength(20),
                        Forms\Components\Select::make('organization_id')
                            ->options(\App\Models\Organization::pluck('name', 'id'))
                            ->nullable()
                            ->label(__(self::$langFile . '.organization_id')),
                        Forms\Components\Select::make('sector_id')
                            ->options(\App\Models\Constant::where('type', ConstantsTypes::Sectors->value)
                                ->pluck('name', 'id'))
                            ->nullable()
                            ->label(__(self::$langFile . '.sector_id')),
                        Forms\Components\Textarea::make('bio')
                            ->label(__(self::$langFile . '.bio'))
                            ->maxLength(1000)
                            ->rows(2),
                    ]),



            ])
            ->model($this->getUser())
            ->statePath('profileData');
    }

    public function editPasswordForm(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('person.edit_password.section.title'))
                    ->description(__('person.edit_password.section.description'))
                    ->schema([
                        Forms\Components\TextInput::make('current_password')
                            ->password()
                            ->label(__('person.edit_password.fields.current'))
                            ->required()
                            ->currentPassword(),
                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->label(__('person.edit_password.fields.new'))
                            ->required()
                            ->rule(Password::default())
                            ->autocomplete('new-password')
                            ->dehydrateStateUsing(fn($state) => Hash::make($state))
                            ->live(debounce: 500)
                            ->same('passwordConfirmation'),
                        Forms\Components\TextInput::make('passwordConfirmation')
                            ->password()
                            ->label(__('person.edit_password.fields.confirm'))
                            ->required()
                            ->dehydrated(false),
                    ])

            ])
            ->model($this->getUser())
            ->statePath('passwordData');
    }

    protected function getUser(): Authenticatable & Model
    {
        $user = Filament::auth()->user();

        if (! $user instanceof Model) {
            throw new Exception(__('person.errors.user_not_model'));
        }

        return $user;
    }

    protected function fillForms(): void
    {
        $data = $this->getUser()->attributesToArray();

        $this->callHook('beforeFill');

        $this->fill([
            'profileData' => $data,
            'passwordData' => [],
        ]);

        $this->callHook('afterFill');
    }

    protected function getUpdateProfileFormActions(): array
    {
        return [
            Action::make('updateProfileAction')
                ->label(__('filament-panels::pages/auth/edit-profile.form.actions.save.label'))
                ->submit('editProfileForm'),
        ];
    }
    protected function getUpdatePasswordFormActions(): array
    {
        return [
            Action::make('updatePasswordAction')
                ->label(__('filament-panels::pages/auth/edit-profile.form.actions.save.label'))
                ->submit('editPasswordForm'),
        ];
    }

    public function updateProfile(): void
    {
        $data = $this->getForm('editProfileForm')->getState();

        $this->handleRecordUpdate($this->getUser(), $data);

        $this->sendSuccessNotification(__('person.notifications.profile_updated'));
    }
    public function updatePassword(): void
    {
        $data = $this->getForm('editPasswordForm')->getState();

        $this->handleRecordUpdate($this->getUser(), [
            'password' => $data['password'],
        ]);

        if (request()->hasSession() && array_key_exists('password', $data)) {
            request()->session()->put('password_hash_' . Filament::getAuthGuard(), $data['password']);
        }

        $this->fillForms(); // Clear the password form after update

        $this->sendSuccessNotification(__('person.notifications.password_updated'));
    }
    private function handleRecordUpdate(Model $record, array $data): Model
    {
        $record->update($data);

        return $record;
    }
    private function sendSuccessNotification(string $message): void
    {
        Notification::make()
            ->title($message)
            ->success()
            ->send();
    }
}

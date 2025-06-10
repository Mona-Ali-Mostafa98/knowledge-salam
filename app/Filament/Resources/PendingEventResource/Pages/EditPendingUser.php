<?php

namespace App\Filament\Resources\PendingUserResource\Pages;

use App\Filament\Resources\PendingUserResource;
use App\Notifications\UserUpdateStatusNotification;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Log;

class EditPendingUser extends EditRecord
{
    protected static string $resource = PendingUserResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (! isset($data['password']) || empty($data['password'])) {
            unset($data['password']);
        }

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterSave(): void
    {
        if ($this->record->wasChanged('approval_status')) {
            // Log::info('User approved: ' . $this->record->email);
            $this->record->notify(new UserUpdateStatusNotification($this->record));
        }
    }
}

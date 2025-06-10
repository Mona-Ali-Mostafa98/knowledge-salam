<?php

namespace App\Filament\Resources\ReviewedUserResource\Pages;

use App\Filament\Resources\PendingUserResource;
use App\Filament\Resources\ReviewedUserResource;
use App\Notifications\UserUpdateStatusNotification;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReviewedUser extends EditRecord
{
    protected static string $resource = ReviewedUserResource::class;

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

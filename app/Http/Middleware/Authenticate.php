<?php

namespace App\Http\Middleware;

use Filament\Facades\Filament;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Exceptions\HttpResponseException;

class Authenticate extends Middleware
{
    /**
     * @param array<string> $guards
     */
    protected function authenticate($request, array $guards): void
    {
        $guard = Filament::auth();

        if (!$guard->check()) {
            $this->unauthenticated($request, $guards);
            return;
        }

        $this->auth->shouldUse(Filament::getAuthGuard());

        /** @var Model $user */
        $user = $guard->user();
        if ($user->approval_status !== 'approved') {
            Auth::logout();

            throw new HttpResponseException(
                redirect()->route('filament.admin.auth.login')
                    ->withErrors(['email' => 'Your account is not approved yet.'])
            );
        }

        // Ensure the user has access to the current panel
        $panel = Filament::getCurrentPanel();

        abort_if(
            $user instanceof FilamentUser ?
                (!$user->canAccessPanel($panel)) :
                (config('app.env') !== 'local'),
            403,
        );
    }

    protected function redirectTo($request): ?string
    {
        return Filament::getLoginUrl();
    }
}

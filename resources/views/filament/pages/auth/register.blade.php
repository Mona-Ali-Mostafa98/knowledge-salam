<div class="custom-login-card bg-white p-8 rounded-lg shadow-lg w-75">
    <section class="grid auto-cols-fr gap-y-6">
        <header class="fi-simple-header flex flex-col items-center">
            <img alt="salam logo" src="{{ asset('images/salam.png') }}" class="fi-logo flex mb-4 w-32 mx-auto">
            <h1
                class="fi-simple-header-heading text-center text-2xl font-bold tracking-tight text-gray-950 dark:text-white">
                {{ $this->getHeading()}}
            </h1>
        </header>

        {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::AUTH_REGISTER_FORM_BEFORE, scopes: $this->getRenderHookScopes()) }}
        <x-filament-panels::form id="form" wire:submit="register">
            {{ $this->form }}

            <x-filament-panels::form.actions
                :actions="$this->getCachedFormActions()"
                :full-width="$this->hasFullWidthFormActions()"
            />
        </x-filament-panels::form>
        {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::AUTH_REGISTER_FORM_AFTER, scopes: $this->getRenderHookScopes()) }}

        <p class="fi-simple-header-subheading mt-2 text-center text-sm text-gray-500 dark:text-gray-400">
            {{ __('filament-panels::pages/auth/register.actions.login.before') }}
            <a href="{{ url('/admin/login') }}"
               class="fi-link group/link relative inline-flex items-center justify-center outline-none fi-size-md fi-link-size-md gap-1.5 fi-color-custom fi-color-primary fi-ac-action fi-ac-link-action">
                    <span
                        class="font-semibold text-sm text-custom-600 dark:text-custom-400 group-hover/link:underline group-focus-visible/link:underline"
                        style="--c-400:var(--primary-400);--c-600:var(--primary-600);">
                        {{ $this->loginAction() }}
                    </span>
            </a>
        </p>
    </section>
</div>

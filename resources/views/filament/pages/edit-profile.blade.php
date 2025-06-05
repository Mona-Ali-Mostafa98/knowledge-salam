<div x-data="{ tab: 'profile' }">
    <div class="my-6 border-b border-gray-200">
        <nav class="flex flex-wrap -mb-px" aria-label="Tabs">
            <!-- Profile Tab -->
            <button
                class="group inline-flex items-center py-3 px-6 text-sm font-semibold focus:outline-none transition-colors duration-200"
                :class="tab === 'profile' ? 'border-b-2 border-primary-600 text-primary-700 bg-gray-50 shadow-sm' : 'text-gray-500 hover:text-primary-600 hover:bg-gray-100'"
                @click="tab = 'profile'"
                type="button"
            >
                <svg class="w-5 h-5 mr-2 text-primary-500" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24" :class="tab === 'profile' ? '' : 'opacity-50'">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                {{ __('person.profile.section.title') }}
            </button>

            <!-- Password Tab -->
            <button
                class="group inline-flex items-center py-3 px-6 text-sm font-semibold focus:outline-none transition-colors duration-200"
                :class="tab === 'password' ? 'border-b-2 border-primary-600 text-primary-700 bg-gray-50 shadow-sm' : 'text-gray-500 hover:text-primary-600 hover:bg-gray-100'"
                @click="tab = 'password'"
                type="button"
            >
                <svg class="w-5 h-5 mr-2 text-primary-500" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24" :class="tab === 'password' ? '' : 'opacity-50'">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 11c1.657 0 3-1.343 3-3V7a3 3 0 10-6 0v1c0 1.657 1.343 3 3 3zm6 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2v-6m12 0a2 2 0 00-2-2H8a2 2 0 00-2 2m12 0V9a6 6 0 10-12 0v4"/>
                </svg>
                {{ __('person.edit_password.section.title') }}
            </button>
        </nav>
    </div>

    <!-- Profile Form -->
    <div x-show="tab === 'profile'">
        <x-filament-panels::form id="form" wire:submit="updateProfile">
            {{ $this->editProfileForm }}

            <div class="mt-6">
                <button
                    type="submit"
                    class="inline-flex items-center px-4 py-2 bg-primary-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition"
                    wire:loading.attr="disabled"
                    wire:target="updateProfile"
                >
                    <svg
                        wire:loading
                        wire:target="updateProfile"
                        class="animate-spin -ml-1 mr-2 h-5 w-5 text-white"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                    >
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                        <path
                            class="opacity-75"
                            fill="currentColor"
                            d="M4 12a8 8 0 018-8v4l3-3-3-3v4a8 8 0 00-8 8h4z"
                        />
                    </svg>
                    <span wire:loading.remove wire:target="updateProfile">
                        {{ __('person.Save Profile') }}
                    </span>
                    <span wire:loading wire:target="updateProfile">
                        {{ __('person.Saving...') }}
                    </span>
                </button>
            </div>
        </x-filament-panels::form>
    </div>

    <!-- Password Form -->
    <div x-show="tab === 'password'">
        <x-filament-panels::form id="form" wire:submit="updatePassword">
            {{ $this->editPasswordForm }}

            <div class="mt-6">
                <button
                    type="submit"
                    class="inline-flex items-center px-4 py-2 bg-primary-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition"
                    wire:loading.attr="disabled"
                    wire:target="updatePassword"
                >
                    <svg
                        wire:loading
                        wire:target="updatePassword"
                        class="animate-spin -ml-1 mr-2 h-5 w-5 text-white"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                    >
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                        <path
                            class="opacity-75"
                            fill="currentColor"
                            d="M4 12a8 8 0 018-8v4l3-3-3-3v4a8 8 0 00-8 8h4z"
                        />
                    </svg>
                    <span wire:loading.remove wire:target="updatePassword">
                        {{ __('person.Update Password') }}
                    </span>
                    <span wire:loading wire:target="updatePassword">
                        {{ __('person.Updating...') }}
                    </span>
                </button>
            </div>
        </x-filament-panels::form>
    </div>
</div>

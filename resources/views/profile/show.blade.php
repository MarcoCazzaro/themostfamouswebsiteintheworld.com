<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Profile') }}
            </h1>
            <div class="h-100 flex flex-col text-amber-500">
                <a href="{{ route('users.show', ['user' => auth()->user() ]) }}">{{ __('View your profile') }} <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                @livewire('profile.update-profile-information-form')

                <x-section-border />

                <div class="mt-10 sm:mt-0" id="edit-tags">
                    @livewire('profile.update-tags-form')
                </div>

                <x-section-border />

                <div class="mt-10 sm:mt-0">
                    @livewire('profile.update-social-links-form')
                </div>

                <x-section-border />
            @endif

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.update-password-form')
                </div>

                <x-section-border />
            @endif

            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.two-factor-authentication-form')
                </div>

                <x-section-border />
            @endif

            <div class="mt-10 sm:mt-0">
                @livewire('profile.logout-other-browser-sessions-form')
            </div>

            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                <x-section-border />

                <div class="mt-10 sm:mt-0">
                    @livewire('profile.delete-user-form')
                </div>
            @endif

            <x-section-border />

            <div class="mt-10 sm:mt-0 flex flex-wrap justify-center p-4 text-gray-600">
                <p>{{ __('If you have any request regarding your profile and / or GDPR, please send an email to') }}</p>
                <img class="m-2" src="{{ asset('img/privacy-email.png') }}" alt="privacy at snappysnail dot io">
            </div>
        </div>
    </div>
</x-app-layout>

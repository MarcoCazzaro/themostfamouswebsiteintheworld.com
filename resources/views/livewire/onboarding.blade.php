<div x-data @open-onboarding.window="$store.showOnboarding = true">
    <div x-cloak x-show="$store.showOnboarding" x-transition.opacity>
        <div class="ssnail-content">
            @include('dashboard.onboarding.' . app()->getLocale())
        </div>
        <div class="flex justify-end">
            <x-button x-on:click="$wire.okGotIt(); $store.showOnboarding = false">{{ __('OK, got it!') }}</x-button>
        </div>
    </div>
</div>

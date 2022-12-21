<div x-data="{ open: !$wire.shown }">
    <div class="text-right" x-cloak x-show="!open" x-transition.opacity>
        <button x-on:click="open = ! open" class="float-right text-amber-500">{{ __('Onboarding') }} <i class="fas fa-book"></i></button>
    </div>
    <div x-cloak x-show="open" x-transition.opacity>
        <div class="ssnail-content">
            @include('dashboard.onboarding.' . app()->getLocale())
        </div>
        <div class="flex justify-end">
            <x-jet-button x-on:click="$wire.okGotIt(); open = false">{{ __('OK, got it!') }}</x-jet-button>
        </div>
    </div>
</div>

<div wire:init="loadStats">
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4">
        <x-jet-dropdown align="left" width="60">
            <x-slot name="trigger">
                <span class="inline-flex rounded-md">
                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-gray-50 hover:bg-amber-100 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition">
                        {{ $timePeriod }}
                        <i class="fas fa-chevron-down ml-1"></i>
                    </button>
                </span>
            </x-slot>

            <x-slot name="content">
                <div class="w-60" x-data="{}">
                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Select time period') }}
                    </div>
                    @foreach ($availableTimePeriods as $availableTimePeriod)
                        <x-jet-dropdown-link href="javascript:void(0)" x-on:click="$wire.set('timePeriod', '{{ $availableTimePeriod }}')">
                            {{ __($availableTimePeriod) }}
                        </x-jet-dropdown-link>
                    @endforeach
                </div>
            </x-slot>
        </x-jet-dropdown>
        <div x-data x-show="$wire.timePeriod == 'Custom dates'">
            <x-jet-input id="startDate" type="date" wire:model="startDate"/>
        </div>
        <div x-data x-show="$wire.timePeriod == 'Custom dates'">
            <x-jet-input id="endDate" type="date" wire:model="endDate"/>
        </div>
    </div>
    <div class="ssnail-content relative">
        <div wire:loading class="absolute">
            <div class="text-center text-gray-400">
                <i class="fas fa-rotate animate-spin"></i>
            </div>
        </div>
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-4 mt-8">
            <div class="flex flex-col items-center">
                <span class="text-2xl">{{ $stats["received"]["famous_points"] ?? 0 }}</span>
                <label class="text-xs text-gray-500">{{ __('famous points received') }}</label>
            </div>
            <div class="flex flex-col items-center">
                <span class="text-2xl">{{ $stats["received"]["users"] ?? 0 }}</span>
                <label class="text-xs text-gray-500">{{ __('fans') }}</label>
            </div>
            <div class="flex flex-col items-center">
                <span class="text-2xl">{{ $stats["given"]["famous_points"] ?? 0 }}</span>
                <label class="text-xs text-gray-500">{{ __('famous points given') }}</label>
            </div>
            <div class="flex flex-col items-center">
                <span class="text-2xl">{{ $stats["given"]["users"] ?? 0 }}</span>
                <label class="text-xs text-gray-500">{{ __('users you supported') }}</label>
            </div>
        </div>
    </div>
</div>

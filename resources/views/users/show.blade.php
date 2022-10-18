<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $user->name }}
        </h2>
        <div class="ssnail-points">{{ $user->total_famous_points }}</div>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            @livewire('increment-famousness', compact('user'))
        </div>
    </div>
</x-app-layout>

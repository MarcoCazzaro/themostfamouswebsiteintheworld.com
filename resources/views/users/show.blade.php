<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $user->name }}
        </h2>
        <div class="ssnail-points">{{ $user->total_famous_points }}</div>
    </x-slot>

    <div class="bg-white shadow fixed bottom-0 w-full transition-height duration-500 ease-in-out h-20 hover:h-96">
        <div class="max-w-7xl mx-auto py-3 px-6 lg:px-8">
            @livewire('increment-famousness', compact('user'))
        </div>
    </div>
</x-app-layout>

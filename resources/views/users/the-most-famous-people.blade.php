<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $title }}
            </h1>
            <div class="h-100 flex flex-col text-amber-500">
                <a href="{{ route('search') }}"><i class="fas fa-search"></i> {{ __('Search') }}</a>
            </div>
        </div>
    </x-slot>

    <x-layout.container>
        <section class="mb-16">
            <div class="ssnail-most-famous-{{ $subjects }}">
                <h2 class="font-semibold">Global ranking</h2>
                @livewire('users-list', ['scope' => 'most_famous_' . $subjects, 'highlightFirst' => true, 'showPosition' => true])
            </div>
        </section>
    </x-layout.container>
</x-app-layout>

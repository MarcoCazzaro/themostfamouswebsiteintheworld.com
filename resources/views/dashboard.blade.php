<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
                <h1 class="mb-8">Under construction</h1>
                <p class="mb-8">Visit your profile page: <a href="{{ route('users.show', ['user' => auth()->user() ]) }}">{{ auth()->user()->name }} <i class="fas fa-arrow-right"></i></a></p>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <div class="flex items-center flex-wrap">
                <div class="basis-full sm:basis-auto mr-0 sm:mr-8">
                    <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ $tag->name }}
                    </h1>
                    <div>
                        <a href="{{ route('rankings.index') }}" class="mr-4 text-gray-500"><i class="fas fa-arrow-left"></i> <span class="text-sm">{{ __('See all the rankings') }}</span></a>
                    </div>
                </div>
                <span class="mr-8 mt-4 sm:mt-0">{{ $tag->users()->count() }} users</span>
            </div>
            @can('supadupaadminshit')
                <div class="h-100 flex flex-col text-amber-500">
                    <a href="{{ route('tags.edit', $tag) }}"><i class="fas fa-pen-to-square"></i> {{ __('Edit') }}</a>
                    <x-delete-model :tag="$tag"></x-delete-model>
                </div>
            @endcan
        </div>
    </x-slot>


    <x-layout.container>
        <div class="ssnail-users">
            <h2 class="font-semibold">Ranking</h2>
            @livewire('users-list', ['tag' => $tag, 'highlightFirst' => true])
        </div>
    </x-layout.container>
</x-app-layout>

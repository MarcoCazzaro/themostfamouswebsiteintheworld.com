<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $user->name }}
        </h2>
    </x-slot>

    <?php
        $profile_photo_path = asset('img/logo-squared.png');
        if ($user->profile_photo_path ?? false) {
            $profile_photo_path = Storage::url($user->profile_photo_path);
        }
    ?>
    <div class="flex justify-center w-full p-8">
        <img class="mb-3 w-24 h-24 rounded-full border border-amber-300 bg-white" src="{{  $profile_photo_path }}" alt="{{ $user->name }}">
    </div>

    <x-layout.container>
        <?php
            $followers = $user->followers;
        ?>
        <h2 class="font-semibold">Users following {{ $user->name }}: {{ $followers->count() }}</h2>
        <div class="ssnail-followers">
            <div class="inline-grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4 py-8 justify-center w-full">
                @if($followers->count() > 0)
                    @foreach($followers as $user)
                        <div class="px-16 md:px-0 min-w-fit">
                            @include('partials.user-card', compact('user'))
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </x-layout.container>

    <div class="bg-white shadow fixed bottom-0 w-full transition-height duration-500 ease-in-out h-20 hover:h-64 sm:hover:h-48">
        <div class="max-w-7xl mx-auto py-3 px-6 lg:px-8">
            @livewire('increment-famousness', compact('user'))
        </div>
    </div>
</x-app-layout>

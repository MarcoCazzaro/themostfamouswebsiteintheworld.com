<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center flex-wrap">
            <div class="flex items-center basis-full sm:basis-auto mr-0 sm:mr-8">
                <div class="flex justify-center mr-4 shrink-0">
                    <img class="w-12 h-12 rounded-full border border-amber-300 bg-white" src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}">
                </div>
                <div>
                    <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ $user->name }}
                    </h1>
                    <x-tags-list :tags="$user->tags"></x-tags-list>
                </div>
            </div>
            <span class="mr-8 mt-4 sm:mt-0">{{ $user->followers_count }} followers</span>
            <span class="mr-8 mt-4 sm:mt-0">{{ $user->following_count }} following</span>
        </div>
    </x-slot>

    <x-layout.container>
        <?php
            $followers = $user->best_followers;
        ?>
        <div class="ssnail-followers best">
            <h2 class="font-semibold">Best followers <span class="ssnail-refresh hidden"><a href="javascript:location.reload()"><i class="fas fa-rotate animate-pulse text-gray-500"></i></a></span></h2>
            @if($followers->count() > 0)
                @livewire('users-list', ['currentUsers' => $followers])
            @else
                <p class="py-4">{{ $user->name }} has no followers yet.</p>
            @endif
        </div>
    </x-layout.container>

    <x-layout.container>
        <?php
            $followers = $user->latest_followers;
        ?>
        <div class="ssnail-followers latest">
            <h2 class="font-semibold">Latest followers <span class="ssnail-refresh hidden"><a href="javascript:location.reload()"><i class="fas fa-rotate animate-pulse text-gray-500"></i></a></span></h2>
            @if($followers->count() > 0)
                @livewire('users-list', ['currentUsers' => $followers])
            @else
                <p class="py-4">{{ $user->name }} has no followers yet.</p>
            @endif
        </div>
    </x-layout.container>

    <x-layout.container class="pb-24">
        <?php
            $following = $user->best_following;
        ?>
        <div class="ssnail-following">
            <h2 class="font-semibold">Best following <span class="ssnail-refresh hidden"><a href="javascript:location.reload()"><i class="fas fa-rotate animate-pulse text-gray-500"></i></a></span></h2>
            @if($following->count() > 0)
                @livewire('users-list', ['currentUsers' => $following])
            @else
                <p class="py-4">{{ $user->name }} is not following anyone yet.</p>
            @endif
        </div>
    </x-layout.container>

    <div class="bg-white shadow fixed bottom-0 w-full transition-height duration-500 ease-in-out h-20 hover:h-64 sm:hover:h-48">
        <div class="max-w-7xl mx-auto py-3 px-6 lg:px-8">
            @livewire('increment-famousness', compact('user'))
        </div>
    </div>

    @push('scripts')
        <script>
            window.addEventListener('ssnail-points-updated', event => {
                let resfreshButtons = document.getElementsByClassName('ssnail-refresh');
                for (let resfreshButton of resfreshButtons) {
                    resfreshButton.classList.remove('hidden');
                }
            })
        </script>
    @endpush
</x-app-layout>

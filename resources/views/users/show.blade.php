<x-app-layout>
    <x-slot name="header">
        <div class="flex">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $user->name }}
            </h2>
            <span class="pl-8">{{ $user->followers_count }} followers</span>
            <span class="pl-8">{{ $user->following_count }} following</span>
        </div>
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
            $followers = $user->latest_followers;
        ?>
        <div class="ssnail-followers">
            <h2 class="font-semibold">Latest followers <span class="ssnail-refresh hidden"><a href="javascript:location.reload()"><i class="fas fa-rotate animate-spin text-gray-500"></i></a></span></h2>
            @livewire('users-list', ['currentUsers' => $followers])
        </div>
    </x-layout.container>

    <x-layout.container>
        <?php
            $following = $user->latest_following;
        ?>
        <div class="ssnail-followers">
            <h2 class="font-semibold">Latest following <span class="ssnail-refresh hidden"><a href="javascript:location.reload()"><i class="fas fa-rotate animate-spin text-gray-500"></i></a></span></h2>
            @livewire('users-list', ['currentUsers' => $following])
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

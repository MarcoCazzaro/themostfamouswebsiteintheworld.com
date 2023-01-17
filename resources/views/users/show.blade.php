<x-app-layout padded-footer="1">
    <x-slot name="header">
        <div class="flex justify-between">
            <div class="flex items-center flex-wrap">
                <div class="flex items-center basis-full sm:basis-auto mr-0 sm:mr-8">
                    <div class="flex justify-center mr-4 shrink-0">
                        <img class="w-12 h-12 object-cover rounded-full border border-amber-300 bg-white" src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}">
                    </div>
                    <div>
                        <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                            {{ $user->nameWithYou }}
                        </h1>
                        <x-tags-list :tags="$user->tags"></x-tags-list>
                        <div class="ssnail-points text-xs inline-flex items-center">
                            <span>{{ $user->famous_points_received_human }}</span>
                            <x-jet-application-logo class="inline h-3 w-auto ml-1" />
                        </div>
                    </div>
                </div>

                <span class="mr-8 mt-4 sm:mt-0">{{ $user->followers_count }} followers</span>
                <span class="mr-8 mt-4 sm:mt-0">{{ $user->following_count }} following</span>
            </div>
            @can('supadupaadminshit')
                <div class="h-100 flex flex-col text-amber-500">
                    @canImpersonate($guard = null)
                        <a href="{{ route('impersonate', $user->id) }}"><i class="fas fa-mask"></i> Impersonate</a>
                    @endCanImpersonate
                    <a href="{{ route('users.edit', $user) }}"><i class="fas fa-pen-to-square"></i> {{ __('Edit') }}</a>
                    <form  method="POST" action="{{ route('users.user-recount-points', $user) }}">
                        @csrf
                        <button type="submit"><i class="fas fa-calculator"></i> <span class="">{{ __('Recalc') }}</span></button>
                    </form>
                    <x-delete-model :user="$user"></x-delete-model>
                </div>
            @endcan
        </div>
    </x-slot>

    <x-layout.container>
        @if($user->isCeleb)
            <div class="bg-gray-100 text-gray-500 text-center p-2 mb-5">
                <p>{{ __('This profile page has not been claimed by :name yet. If you have the rights to claim it, please contact us on our Twitter page:', ['name' => $user->name]) }} <a target="_blank" class="font-bold" href="https://twitter.com/tmfwitw">@tmfwitw</a></p>
            </div>
        @endif
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="ssnail-global-ranking-position bg-white rounded-lg border p-6 flex flex-wrap items-center justify-between">
                <div class="flex items-center">
                    <h2 class="font-semibold mr-4">Global ranking position</h2>
                    <a href="{{ route('most-famous-people') }}">
                        <div class="ssnail-grp rounded-full text-white bg-amber-500 text-2xl flex justify-center items-center font-bold w-14 h-14">
                            {{ $user_ranking_position ?? '' }}
                        </div>
                    </a>
                </div>
                <a class="float-right text-gray-500" href="{{ route('most-famous-people') }}"><span class="hidden md:inline">See full ranking</span> <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="bg-white rounded-lg border p-6 flex flex-wrap items-center justify-between">
                <h2 class="font-semibold mr-4">Social links</h2>
                <div class="ssnail-social-links flex flex-wrap justify-center items-center">
                    @foreach($user->socialLinks as $social)
                        <a href="{{ $social->value }}" rel="noopener nofollow" target="_blank" class="text-amber-500 mr-4">
                            <i class="fab fa-{{ $social->name }} fa-2x"></i>
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="bg-white rounded-lg border p-6 col-span-1 md:col-span-2">
                <h2 class="font-semibold mr-4">Status</h2>
                <div class="ssnail-user-status">
                    @if($user->has('lastStatus') && !is_null($user->lastStatus))
                        {!! $user->lastStatus->body !!}
                        @if($user->id === auth()->user()->id)
                            <p class="text-right"><a href="{{ route('statuses.index') }}" class="text-amber-500"><i class="fas fa-pen-to-square"></i> {{ __('Edit Status') }}</a><p>
                        @endif
                    @else
                        @if($user->id === auth()->user()->id)
                            <p>{{ __('Click here to add a status:') }} <a href="{{ route('statuses.create') }}" class="text-amber-500"><i class="fas fa-plus"></i> {{ __('Add Status') }}</a></p>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </x-layout.container>

    <x-layout.container>
        <?php
            $followers = $user->best_followers;
        ?>
        <div class="ssnail-followers best">
            <h2 class="font-semibold">Best fans <span class="ssnail-refresh hidden"><x-refresh-button /></span></h2>
            @if($followers->count() > 0)
                @livewire('users-list', ['users' => $followers])
            @else
                <p class="py-4">{{ $user->nameWithYou }} has no followers yet.</p>
            @endif
        </div>
    </x-layout.container>

    <x-layout.container>
        <?php
            $followers = $user->latest_followers;
        ?>
        <div class="ssnail-followers latest">
            <h2 class="font-semibold">Latest fans <span class="ssnail-refresh hidden"><x-refresh-button /></span></h2>
            @if($followers->count() > 0)
                @livewire('users-list', ['users' => $followers])
            @else
                <p class="py-4">{{ $user->nameWithYou }} has no followers yet.</p>
            @endif
        </div>
    </x-layout.container>

    <x-layout.container class="pb-24">
        <?php
            $following = $user->best_following;
        ?>
        <div class="ssnail-following">
            <h2 class="font-semibold">Best following <span class="ssnail-refresh hidden"><x-refresh-button /></span></h2>
            @if($following->count() > 0)
                @livewire('users-list', ['users' => $following])
            @else
                <p class="py-4">{{ $user->nameWithYou }} is not following anyone yet.</p>
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

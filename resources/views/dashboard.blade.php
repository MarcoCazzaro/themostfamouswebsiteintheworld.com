<x-app-layout>
    <?php
        $user = auth()->user();
        $show_onboarding = !filter_var(getUserOption('onboarding.shown'), FILTER_VALIDATE_BOOLEAN);
        $show_complete_profile_suggestion = !filter_var(getUserOption('profile.completed'), FILTER_VALIDATE_BOOLEAN);
    ?>
    <div x-data x-init="Alpine.store('showOnboarding', {{ $show_onboarding }})"></div>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h1>
        </div>
    </x-slot>

    <section class="pt-12 pb-6" x-data x-show="$store.showOnboarding">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
                <livewire:onboarding>
            </div>
        </div>
    </section>

    @if($show_complete_profile_suggestion)
        <section class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
                    <h3 class="font-semibold">{{ __('Complete your profile') }}</h3>
                    <p>{{__('Change your profile picture, set your tags, add up to 3 social links')}}.</p>
                    <div class="pt-4 text-center">
                        <form method="GET" action="{{ route('profile.show') }}">
                            <x-jet-button type="submit" class="">{{ __('Complete') }}</x-jet-button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <section class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
                <h3 class="font-semibold">{{ __('Follow new people') }}</h3>
                <p>{{__('Search for your idols and start following them')}}!</p>
                <div class="pt-4 text-center">
                    <form method="GET" action="{{ route('search') }}">
                        <x-jet-button type="submit" class="w-36">{{ __('Search') }}</x-jet-button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
                <h3 class="font-semibold">{{ __('Your status') }}</h3>
                <div class="ssnail-user-status">
                    @if($user->has('lastStatus') && !is_null($user->lastStatus))
                        <div class="bg-amber-100 border border-amber-500 my-4 p-8 sm:rounded-lg">{!! $user->lastStatus->body !!}</div>
                        <?php
                            $status_link = route('statuses.index');
                            $status_text = __('Edit Status');
                        ?>
                    @else
                        <p>{{ __('Tell us something about yourself') }}.</p>
                        <?php
                            $status_link = route('statuses.create');
                            $status_text = __('Add Status');
                        ?>
                    @endif
                    <div class="pt-4 text-center">
                        <form method="GET" action="{{ $status_link }}">
                            <x-jet-button type="submit" class="w-36">{{ $status_text }}</x-jet-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
                <div class="pb-8">
                    <h3 class="font-semibold">{{ __('Your tags') }}</h3>
                    <p>{{__('You can appear in up to 5 rankings by selecting tags')}}.</p>

                    @if($user->tags->count() > 0)
                        <div class="mt-4">
                            <x-tags-list :tags="$user->tags"></x-tags-list>
                        </div>
                        @php($tags_label = __("Edit tags"))
                    @else
                        <p>{{ __("You didn't select any tags yet, why don't you try a few?") }}</p>
                        @php($tags_label = __("Select tags"))
                    @endif
                    <div class="mt-4 text-center">
                        <form method="GET" action="{{ route('profile.show') }}#edit-tags">
                            <x-jet-button type="submit" class="w-36">{{ $tags_label }}</x-jet-button>
                        </form>
                    </div>
                </div>
                <div>
                    <h3 class="font-semibold">{{ __('Your rankings') }}</h3>
                    <livewire:user-rankings :user="$user"></livewire:user-rankings>
                </div>
            </div>
        </div>
    </section>

    <section class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
                <h3 class="font-semibold">{{ __('Latest followers') }}</h3>
                <?php
                    $followers = $user->latest_followers->take(4);
                ?>
                <div class="ssnail-followers latest">
                    @if($followers->count() > 0)
                        @livewire('users-list', ['users' => $followers])
                    @else
                        <p class="py-4">{{ __("You have no followers yet, why don't you share the") }} ❤️?</p>
                        <div class="pt-4">
                            <x-share-profile />
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
                <h3 class="font-semibold">{{ __('Latest following') }}</h3>
                <?php
                    $following = $user->latest_following->take(4);
                ?>
                <div class="ssnail-following latest">
                    @if($following->count() > 0)
                        @livewire('users-list', ['users' => $following])
                    @else
                        <p class="py-4">{{ __("You are not following anyone yet, why don't you search for someone famous") }}?</p>
                        <div class="pt-4 text-center">
                            <form method="GET" action="{{ route('search') }}">
                                <x-jet-button type="submit" class="w-36">{{ __('Search') }}</x-jet-button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl sm:rounded-lg p-8">
                <h3 class="font-semibold">{{ __('Your stats') }}</h3>
                <p>{{__('See how you are going in The Most Famous Website In The World')}}</p>
                <div class="pt-4">
                    @livewire('user-stats')
                </div>
            </div>
        </div>
    </section>

    <section class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
                <h3 class="font-semibold">{{ __('Share the') }} ❤️</h3>
                <p>{{__('To increase your famous points, you can drive traffic from your social media platforms by sharing your profile page')}}:</p>
                <div class="pt-4">
                    <x-share-profile />
                </div>
            </div>
        </div>
    </section>

    @if(! $show_onboarding)
    <section class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden">
                <div x-data="{}">
                    <p class="px-8 sm:px-0">{{ __('If you want to see the onboarding procedure again, click on') }} <button x-on:click="Livewire.emit('openOnboarding');window.scrollTo(0,0)" class="text-amber-500">{{ __('Getting started') }} <i class="fas fa-book"></i></button></p>
                </div>
            </div>
        </div>
    </section>
    @endif

    @push('scripts')
        <script>
            let suggestedUserSlug = sessionStorage.getItem("tmfwitw-suggested-user-slug");
            if (suggestedUserSlug !== null) {
                sessionStorage.removeItem("tmfwitw-suggested-user-slug");
                window.location.href = "{{ url('/') }}/users/" + suggestedUserSlug;
            }
        </script>
    @endpush
</x-app-layout>
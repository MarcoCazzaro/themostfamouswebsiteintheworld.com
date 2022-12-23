<x-app-layout>
    @php($show_onboarding = !filter_var(getUserOption('onboarding.shown'), FILTER_VALIDATE_BOOLEAN))
    <div x-data x-init="Alpine.store('showOnboarding', {{ $show_onboarding }})"></div>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h1>
            @if(! $show_onboarding)
            <span x-text="$store.showOnboarding"></span>
                <div x-data="{}">
                    <button x-on:click="Livewire.emit('openOnboarding')" class="float-right text-amber-500">{{ __('Help') }} <i class="fas fa-book"></i></button>
                </div>
            @endif
        </div>
    </x-slot>

    <section class="pt-12 pb-6" x-data x-show="$store.showOnboarding">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
                <livewire:onboarding>
            </div>
        </div>
    </section>

    <section class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
                <div class="pb-8">
                    <h3 class="font-semibold">{{ __('Your tags') }}</h3>
                    <p>{{__('You can appear in up to 5 rankings by selecting tags')}}.</p>
                    @php($user = auth()->user())
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
                            <x-jet-button type="submit" class="w-36 m-4">{{ $tags_label }}</x-jet-button>
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
                <h3 class="font-semibold">{{ __('Share the') }} ❤️</h3>
                <p>{{__('To increase your famous points, you can drive traffic from your social media platforms by sharing your profile page')}}:</p>
                <div class="pt-4">
                    <x-share-profile />
                </div>
            </div>
        </div>
    </section>

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
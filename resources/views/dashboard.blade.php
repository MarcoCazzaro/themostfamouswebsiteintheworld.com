<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h1>
    </x-slot>

    <section class="pt-12 pb-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
                <livewire:onboarding>
            </div>
        </div>
    </section>

    <section class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
                <h3 class="font-semibold">{{ __('Share the') }} ❤️</h3>
                <p>{{__('To increase your famous points, you can drive traffic from your social media platforms by sharing your profile page')}}:</p>
                <x-share-profile />
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
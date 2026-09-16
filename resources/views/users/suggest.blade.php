<x-guest-layout>
    <div class="flex justify-center content-center min-h-fit min-w-screen">
        <div class="flex flex-col items-center justify-center p-8">
            <div class="flex flex-row md:flex-col items-center w-full mt-8">
                <img class="grow-0 shrink-0 mb-3 w-16 h-16 md:w-24 md:h-24 object-cover rounded-full border border-amber-300" src="{{ $user->profile_photo_url }}" alt="{{ $user->nameWithYou }}">
                <div class="ml-4 md:ml-0 text-left md:text-center grow">
                    <h5 class="mb-1 text-lg font-medium text-gray-900 md:truncate w-auto md:w-40">{{ $user->nameWithYou }}</h5>
                </div>
            </div>
            <p class="mb-8">{{ __('is on') }}</p>
            <x-application-logo class="h-12 mb-5" />
            <x-application-mark class="h-48" />
        </div>
    </div>
    <div class="flex justify-center content-center min-w-screen">
            @auth

            @else
                <div class="flex items-center justify-center p-8 flex-wrap">
                    <p>Join us, if you want to be in The Most Famous Website In The World.</p>
                    <div class="flex p-8">
                        <form method="GET" action="{{ route('register') }}">
                            <x-button type="submit" class="w-24 m-4">Join</x-button>
                        </form>
                        <form method="GET" action="{{ route('login') }}">
                            <x-button type="submit" class="w-24 m-4">Login</x-button>
                        </form>
                    </div>
                </div>
            @endauth
    </div>
    @push('scripts')
    <script>
        sessionStorage.setItem("tmfwitw-suggested-user-slug", "{{ $user->slug }}");
    </script>
    @endpush
</x-guest-layout>

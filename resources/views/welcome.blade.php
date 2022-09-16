<x-guest-layout>
    <div class="flex justify-center content-center min-h-screen min-w-screen">
        <div class="flex items-center p-8">
            <x-jet-application-logo class="block max-w-7xl w-auto" />
        </div>
    </div>
    <div class="flex justify-center content-center min-w-screen">
            @auth
                <div class="p-8">
                    <div>
                        <p>Ciao, {{ auth()->user()->name }}.</p>
                        <p>Here are the lastest 31 users in The Most Famous Website In The World:</p>
                    </div>
                    <div class="inline-grid grid-cols-3 gap-4 py-8">
                        @if($registered_users ?? false)
                            @foreach($registered_users as $user)
                                @include('partials.user-card', compact('user'))
                            @endforeach
                        @endif
                    </div>
                </div>
            @else
                <div class="flex items-center justify-center p-8 flex-wrap">
                    <p>Join us, if you want to be in The Most Famous Website In The World.</p>
                    <div class="flex p-8">
                        <form method="GET" action="{{ route('register') }}">
                            <x-jet-button type="submit" class="w-24 m-4">Join</x-jet-button>
                        </form>
                        <form method="GET" action="{{ route('login') }}">
                            <x-jet-button type="submit" class="w-24 m-4">Login</x-jet-button>
                        </form>
                    </div>
                </div>
            @endauth
    </div>
</x-guest-layout>
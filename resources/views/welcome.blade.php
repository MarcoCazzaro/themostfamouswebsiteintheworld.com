<x-guest-layout>
    <div class="flex justify-center content-center min-h-screen min-w-screen">
        <div class="flex flex-col items-center justify-center p-8">
            <x-jet-application-logo class="h-12 mb-5" />
            <x-jet-application-mark class="" />
        </div>
    </div>
    <div class="flex justify-center content-center min-w-screen">
            @auth
                <div class="p-8">
                    <section class="mb-8">
                        <div>
                            <p>Ciao, {{ auth()->user()->name }}.</p>
                            <p>Here are the 13 most famous users in The Most Famous Website In The World:</p>
                        </div>
                        @livewire('users-list', ['scope' => 'most_famous_people', 'highlightFirst' => true, 'showPosition' => true])
                    </section>
                    <section class="mb-8">
                        <div>
                            <p>Here are the latest 12 users in The Most Famous Website In The World:</p>
                        </div>
                        @livewire('users-list', ['scope' => 'latest_users'])
                    </section>
                    <section class="mb-8">
                        <p class="text-center">Find out more:</p>
                        <div class="flex justify-center items-center flex-wrap">
                            <form method="GET" action="{{ route('dashboard') }}">
                                <x-jet-button type="submit" class="w-56 m-4">Your dashboard</x-jet-button>
                            </form>
                            <form method="GET" action="{{ route('users.most-famous-people') }}">
                                <x-jet-button type="submit" class="w-56 m-4">Most famous people</x-jet-button>
                            </form>
                            <form method="GET" action="{{ route('users.most-famous-fans') }}">
                                <x-jet-button type="submit" class="w-56 m-4">Most famous fans</x-jet-button>
                            </form>
                        </div>
                    </section>
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
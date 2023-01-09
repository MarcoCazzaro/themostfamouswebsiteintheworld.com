<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', $SNAIL_SEO_LANGUAGE) }}">
    <head>
        @include('partials.seo')
        @stack('page-preloads')
        @include('partials.preloads')
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://kit.fontawesome.com/fea9be3e02.js" crossorigin="anonymous"></script>

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <x-jet-banner />

        <div class="min-h-screen bg-gray-100">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <x-layout.container>
                        {{ $header }}
                    </x-layout.container>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @stack('modals')

        @stack('scripts')

        @livewireScripts
    </body>
</html>

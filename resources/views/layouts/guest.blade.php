<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', $SNAIL_SEO_LANGUAGE) }}">
    <head>
        @include('partials.seo')
        @include('partials.preloads')
        @stack('page-preloads')
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://kit.fontawesome.com/fea9be3e02.js" crossorigin="anonymous"></script>

        <!-- Styles -->
        @livewireStyles
    </head>
    <body>
        <div class="font-sans text-gray-900 antialiased">
            {{ $slot }}
        </div>
        @include('partials.site-footer')

        @stack('scripts')

        @livewireScripts
    </body>
</html>

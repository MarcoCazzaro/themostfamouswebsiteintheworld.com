<link rel="preload" href="{{ asset('img/logo.png') }}" as="image">
<link
    rel="preload"
    href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap"
    as="style"
    onload="this.onload=null;this.rel='stylesheet'"
/>
<noscript>
    <link
        href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap"
        rel="stylesheet"
        type="text/css"
    />
</noscript>
<?php
    $prefetch_urls = ['most-famous-people', 'most-famous-fans', 'most-famous-tags', 'search'];
    if (auth()->check()) {
        $prefetch_urls[] = 'dashboard';
        $prefetch_urls[] = 'profile.show';
    }
    $url_type = 'route';
?>
@include('partials.prefetch-urls', compact('prefetch_urls', 'url_type'))
@auth()
    <?php
        $prefetch_urls = [
            route('users.show', ['user' => auth()->user() ]),
        ];
        $url_type = 'url';
    ?>
    @include('partials.prefetch-urls', compact('prefetch_urls', 'url_type'))
@endauth



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
	$prefetch_urls = ['users.most-famous-people', 'users.most-famous-fans', 'dashboard', 'profile.show'];
    $url_type = 'route';
?>
@include('partials.prefetch-urls', compact('prefetch_urls', 'url_type'))
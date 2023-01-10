<?php
    /*
    ATTENZIONE - ATTENZIONE - ATTENZIONE - ATTENZIONE - ATTENZIONE - ATTENZIONE - ATTENZIONE - ATTENZIONE - ATTENZIONE
    Per il futuro me: se vuoi evitarti giornate di debug, fa' attenzione quando fai il prefetch delle pagine perché se lo fai con le pagine di registrazione ti parte la sessione e, ad esempio, l'utente non resta loggato subito dopo la registrazione.
    */
?>
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
@auth()
    <?php
        if (auth()->user()->hasVerifiedEmail()) {
            $all_prefetch_urls = [
                'route' => ['most-famous-people', 'most-famous-fans', 'most-famous-tags', 'search', 'dashboard', 'profile.show'],
                'url' => [
                    route('users.show', ['user' => auth()->user() ]),
                ]
            ];
            foreach ($all_prefetch_urls as $url_type => $prefetch_urls) {
                ?>
                @include('partials.prefetch-urls', compact('prefetch_urls', 'url_type'))
                <?php
            }
        }
    ?>
@endauth
<div class="ssnail-share-profile my-4">
    @auth()
        <?php
            $url = route('suggest', auth()->user());
            $title = sprintf(__("Check out %s's page on The Most Famous Website In The World "), auth()->user()->name);
            $via = "The Most Famous Website In The World";
        ?>
        <div class="ssnail-share-buttons flex py-3 justify-center text-amber-500">
            <div class="mx-3">
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $url ?>" target="_blank"><i class="fab fa-facebook-f fa-lg"></i></a>
            </div>
            <div class="mx-3">
                <a target="_blank" href="https://twitter.com/intent/tweet?text=<?= $title ?>&url=<?= $url ?>&via=<?= $via ?>"><i class="fab fa-twitter fa-lg"></i></a>
            </div>
            <div class="mx-3">
                <a target="_blank" href="https://wa.me/send?text=<?= $url ?>"><i class="fab fa-whatsapp fa-lg"></i></a>
            </div>
        </div>
    @endauth
</div>
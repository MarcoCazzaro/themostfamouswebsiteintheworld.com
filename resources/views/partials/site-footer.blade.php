@php($paddedFooter = $paddedFooter ?? false)
<div class="ssnail-site-footer bg-gray-700 text-white">
    <div class="grid grid-cols-1 md:grid-cols-2 p-8">
        <div class="px-0 md:px-8">
            <div class="flex">
                <div class="shrink-0 inline-flex"><x-jet-application-mark class="h-20 mb-8 md:mb-0" /></div>
                <div class="ml-4">
                    <p>&copy;{{ date('Y') }} | All rights reserved</p>
                    <p><b class="font-semibold text-amber-500">The Most Famous Website In The World</b> is owned by:</p>
                    <p class="text-sm">Snappysnail di Marco Cazzaro <br> Via Monte Grappa 119 - 35018 San Martino di Lupari (PD) Italy <br> VAT NUMBER: IT03919560130</p>
                    <div class="ssnail-social-links text-amber-500 mt-4">
                        <a href="https://twitter.com/tmfwitw" target="_blank" rel="noopener nofollow" class="mr-4"><i class="fab fa-twitter fa-xl"></i></a>
                        <a href="https://www.facebook.com/profile.php?id=100089300353495" target="_blank" rel="noopener nofollow" class="mr-4"><i class="fab fa-facebook-f fa-xl"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="px-0 md:px-8 mt-8 md:mt-0">
            <p>
                To contact us, please send an email to <img src="{{ asset('img/info-email.png') }}" alt="info at snappysnail dot io" class="invert inline-flex">
            </p>
            <div class="mt-4">
                <p class="mt-0"><a href="{{ route('terms.show') }}" target="_blank" class="text-amber-500 font-semibold">Terms of service</a></p>
                <p class="mt-0"><a href="{{ route('policy.show') }}" target="_blank" class="text-amber-500 font-semibold">Privacy Policy</a></p>
                <p class="mt-0"><a href="{{ route('cookies') }}" target="_blank" class="text-amber-500 font-semibold">Cookie Policy</a></p>
            </div>
        </div>
    </div>
    @if($paddedFooter)
        <div class="flex h-24 text-gray-700">.</div>
    @endif
</div>
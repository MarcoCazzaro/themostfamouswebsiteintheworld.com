<x-guest-layout>
    <div class="pb-8 bg-gray-100">
        <div class="min-h-screen flex flex-col items-center sm:pt-0">
            <div class="w-full text-center bg-amber-500">
                <a href="{{ route('frontpage') }}"><img src="{{ asset('img/placeholder.jpg') }}" class="m-auto"></a>
            </div>

            <div class="w-full sm:max-w-2xl mt-6 p-6 bg-white shadow-md overflow-hidden sm:rounded-lg">
                <section class="mt-8">
                    <h2 class="font-semibold">What is The Most Famous Website In The World?</h2>
                    <p>It's a website where users are ranked by their popularity, accordingly to their famous points.</p>
                </section>
                <section class="mt-8">
                    <h2 class="font-semibold">What are famous points?</h2>
                    <p>The more famous points <x-jet-application-logo class="inline h-3 w-auto" /> you have, the more popular you are.</p>
                    <p>Every time you visit a user's profile page, you can see a progress bar on the bottom of the page. Once the progress is 100%, a famous point <x-jet-application-logo class="inline h-3 w-auto" /> is given to that person.</p>
                </section>
                <section class="mt-8">
                    <h2 class="font-semibold">What can I do here?</h2>
                    <p>You can become famous! Either in the <a href="{{ route('most-famous-people') }}" target="_blank" class="text-amber-500 font-bold">Most Famous People</a> ranking or in the <a href="{{ route('most-famous-fans') }}" target="_blank" class="text-amber-500 font-bold">Most Famous Fans</a> ranking.</p>
                </section>
                <section class="mt-8">
                    <h2 class="font-semibold">How can I become a Most Famous Fan?</h2>
                    <p><a href="{{ route('search') }}" target="_blank" class="text-amber-500 font-bold">Search</a> for your favourite Famous People and stay on their profile page. The more you stay, the higher you appear in their fan base.</p>
                </section>
                <section class="mt-8">
                    <h2 class="font-semibold">Why do I need tags?</h2>
                    <p>You can <a href="{{ route('profile.show') }}#edit-tags" target="_blank" class="text-amber-500 font-bold">select up to 5 tags</a> to appear on those tags' rankings, in the <a href="{{ route('most-famous-tags') }}" target="_blank" class="text-amber-500 font-bold">Most Famous Tags</a> page and on each tag page.</p>
                </section>
                <div class="mb-8"></div>
            </div>
        </div>
    </div>
</x-guest-layout>

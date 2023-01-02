@php($gE = \App\Models\User::where('email', 'info@snappysnail.io')->first())
<section>
    <h2 class="font-semibold">Getting started</h2>
</section>
<section class="mt-8">
    <h3 class="font-semibold">What is The Most Famous Website In The World?</h3>
    <p>It's a website created by <a href="{{ $gE->url ?? '' }}" target="_blank" class="text-amber-500 font-bold">gE</a> where users are ranked by their popularity.</p>
</section>
<section class="mt-8">
    <h3 class="font-semibold">What are famous points?</h3>
    <p>The more famous points <x-jet-application-logo class="inline h-3 w-auto" /> you have, the more popular you are.</p>
    <p>Every time you visit a user's profile page, let's say <a href="{{ $gE->url ?? '' }}" target="_blank" class="text-amber-500 font-bold">gE's</a>, you can see a progress bar on the bottom of the page. Once the progress is 100%, a famous point <x-jet-application-logo class="inline h-3 w-auto" /> is given to that person.</p>
    <div class="my-8">
        <div class="bg-white shadow w-full h-64 sm:h-48">
            <div class="max-w-7xl mx-auto py-3 px-6 lg:px-8">
                @livewire('increment-famousness', ['user' => $gE])
            </div>
        </div>
    </div>
</section>
<section class="mt-8">
    <h3 class="font-semibold">What can I do here?</h3>
    <p>You can become famous! Either in the <a href="{{ route('users.most-famous-people') }}" target="_blank" class="text-amber-500 font-bold">Most Famous People</a> ranking or in the <a href="{{ route('users.most-famous-fans') }}" target="_blank" class="text-amber-500 font-bold">Most Famous Fans</a> ranking.</p>
</section>
<section class="mt-8">
    <h3 class="font-semibold">How can I become a Most Famous Fan?</h3>
    <p><a href="{{ route('search') }}" target="_blank" class="text-amber-500 font-bold">Search</a> for your favourite Famous People and stay on their profile page. The more you stay, the higher you appear in their fan base.</p>
</section>
<section class="mt-8">
    <h3 class="font-semibold">Why do I need tags?</h3>
    <p>You can <a href="{{ route('profile.show') }}#edit-tags" target="_blank" class="text-amber-500 font-bold">select up to 5 tags</a> to appear on those tags' rankings, in the <a href="{{ route('tags.most-famous-tags') }}" target="_blank" class="text-amber-500 font-bold">Most Famous Tags</a> page and on each tag page.</p>
</section>
<div class="mb-8"></div>
<section>
    @php($gE = \App\Models\User::where('email', 'info@snappysnail.io')->first())
    <h2 class="font-semibold mb-4">What is The Most Famous Website In The World?</h2>
    <p>It's a website where users are ranked by their popularity.</p>
    <p>Every time you visit a user's profile page, let's say <a href="{{ $gE->url ?? '' }}" target="_blank" class="text-amber-500 font-bold">mine</a>, you can see a progress bar on the bottom of the page. Once the progress is 100%, a famous point <x-jet-application-logo class="inline h-3 w-auto" /> is given to this person.</p>
    <div class="my-8">
        <div class="bg-white shadow w-full h-64 sm:h-48">
            <div class="max-w-7xl mx-auto py-3 px-6 lg:px-8">
                @livewire('increment-famousness', ['user' => $gE])
            </div>
        </div>
    </div>
    <p class="font-semibold">The more points you have, the more famous you are.</p>
</section>
<section class="mt-8">
    <h3 class="font-semibold">The Most Famous People</h3>
    <p>You can then <a href="{{ route('profile.show') }}#edit-tags" target="_blank" class="text-amber-500 font-bold">select up to 5 tags</a>, and you will appear also on those tags' rankings, in the <a href="{{ route('users.most-famous-people') }}" target="_blank" class="text-amber-500 font-bold">Most Famous People</a> page and on each tag page.</p>
    <p>But what are famous people without their fans? <span class="font-bold">NOTHING!</span></p>
</section>
<section class="mt-8">
    <h3 class="font-semibold">The Most Famous Fans</h3>
    <p>The same rules apply to fans as well: when you give famous points to a person, you also appear on their followers section, and you are listed in the <a href="{{ route('users.most-famous-fans') }}" target="_blank" class="text-amber-500 font-bold">Most Famous Fans</a> page and in each tags' ranking section.</p>
</section>
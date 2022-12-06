<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $title }}
            </h1>
            <div class="h-100 flex flex-col text-amber-500">
                <a href="{{ route('search') }}"><i class="fas fa-search"></i> {{ __('Search') }}</a>
            </div>
        </div>
    </x-slot>

    <x-layout.container>
        <section class="mb-16">
            <div class="ssnail-most-famous-{{ $subjects }}">
                <h2 class="font-semibold">Global ranking</h2>
                @livewire('users-list', ['scope' => 'most_famous_' . $subjects, 'highlightFirst' => true, 'showPosition' => true])
            </div>
        </section>
        <section class="mb-16">
            <h2 class="font-semibold mb-4">Ranking of {{ $subjects }} by tag</h2>
            <?php
            $sections_tags = $most_famous_tags->take(13);
            ?>
            @foreach($sections_tags as $tag)
                <div class="ssnail-most-famous-people-by-tag mb-16" data-tag-id="{{ $tag->id }}">
                    <div class="flex justify-between items-center bg-white rounded-lg border shadow-md p-6">
                        <h3 class="font-semibold break-all mr-4">Most famous {{ $subjects }} with tag <span class="text-amber-500 block lg:inline">{{ $tag->name }}</span></h3>
                        <a class="float-right text-gray-500" href="{{ route('users.most-famous-' . $subjects . '.show', $tag) }}"><span class="hidden md:inline">See full ranking</span> <i class="fas fa-arrow-right"></i></a>
                    </div>
                    @livewire('users-list', ['scope' => 'most_famous_' . $subjects . '_by_tag', 'tag_id' => $tag->id, 'highlightFirst' => true, 'showPosition' => true])
                </div>
            @endforeach
        </section>
    </x-layout.container>

    <x-layout.container>
        <div class="w-full bg-white rounded-lg border border-gray-200 shadow-md">
            <div class="flex flex-col p-6">
                <h2 class="font-semibold text-lg text-gray-800">
                    {{ __('Rankings by tags') }}
                </h2>
                <p>Select a tag to check out the ranking of users with that tag.</p>
                <div class="ssnail-tags flex flex-wrap mt-6">
                    @foreach($most_famous_tags as $tag)
                        <div class="pr-4 pb-4 basis-full md:basis-auto">
                            @php($tag_in_array = [$tag])
                            <x-tags-list :tags="$tag_in_array"></x-tags-list>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </x-layout.container>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $title }}
            </h1>
        </div>
    </x-slot>

    <x-layout.container>
        @foreach($most_famous_tags->take(13) as $tag)
            <?php
                if (isset($most_famous_people_by_popular_tag)) {
                    $users = $most_famous_people_by_popular_tag[$tag->id] ?? [];
                } else {
                    $users = $most_famous_fans_by_popular_tag[$tag->id] ?? [];
                }
            ?>
            <div class="ssnail-most-famous-people-by-tag" data-tag-id="{{ $tag->id }}">
                <h2 class="font-semibold">Best followers for {{ $tag->name }}</h2>
                @if(!empty($users))
                    @livewire('users-list', ['currentUsers' => $users, 'highlightFirst' => true, 'showPosition' => true])
                @else
                    <p class="py-4">{{ $tag->name }} has no users yet.</p>
                @endif
            </div>
        @endforeach
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

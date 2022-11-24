<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $title }}
            </h1>
        </div>
    </x-slot>

    <x-layout.container>
        <section class="mb-16">
            <?php
                $subject = isset($most_famous_people) ? 'people' : 'fans';
                $users = $most_famous_people ?? $most_famous_fans ?? [];
            ?>
            <div class="ssnail-most-famous-{{ $subject }}">
                <h2 class="font-semibold">Global ranking</h2>
                @if(!empty($users))
                    @livewire('users-list', ['currentUsers' => $users, 'highlightFirst' => true, 'showPosition' => true])
                @endif
            </div>
        </section>
        <section class="mb-16">
            <h2 class="font-semibold mb-4">Ranking of {{ $subject }} by tag</h2>
            @foreach($most_famous_tags->take(13) as $tag)
                <?php
                    if (isset($most_famous_people_by_popular_tag)) {
                        $users = $most_famous_people_by_popular_tag[$tag->id] ?? [];
                    } else {
                        $users = $most_famous_fans_by_popular_tag[$tag->id] ?? [];
                    }
                ?>
                <div class="ssnail-most-famous-people-by-tag mb-16" data-tag-id="{{ $tag->id }}">
                    <h3 class="font-semibold">Most famous {{ $subject }} for <span class="text-amber-500">{{ $tag->name }}</span> <a class="ml-8 text-gray-500" href="{{ route('users.most-famous-' . $subject . '.show', $tag) }}">See full ranking <i class="fas fa-arrow-right"></i></a></h3>
                    @if(!empty($users))
                        @livewire('users-list', ['currentUsers' => $users, 'highlightFirst' => true, 'showPosition' => true])
                    @else
                        <p class="py-4">{{ $tag->name }} has no users yet.</p>
                    @endif
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

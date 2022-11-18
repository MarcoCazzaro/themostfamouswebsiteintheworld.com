<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Rankings') }}
        </h1>
    </x-slot>

    <x-layout.container>
        <div class="w-full bg-white rounded-lg border border-gray-200 shadow-md">
            <div class="flex flex-col p-6">
                <h2 class="font-semibold text-lg text-gray-800">
                    {{ __('Rankings by tags') }}
                </h2>
                <p>Select a tag to check out the ranking of users with that tag.</p>
                <div class="ssnail-tags flex flex-wrap mt-6">
                    @foreach($tags as $tag)
                        <div class="pr-4 pb-4 basis-full md:basis-auto">
                            @php($tag_in_array = [$tag])
                            <x-tags-list :tags="$tag_in_array"></x-tags-list>
                        </div>
                    @endforeach
                </div>
                {{ $tags->links() }}
            </div>
        </div>
    </x-layout.container>
</x-app-layout>

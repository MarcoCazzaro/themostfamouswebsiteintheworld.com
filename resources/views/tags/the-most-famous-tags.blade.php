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
        <div class="w-full bg-white rounded-lg border border-gray-200 shadow-md">
            <div class="flex flex-col p-6">
                <div class="ssnail-tags flex flex-wrap">
                    @foreach($most_famous_tags as $tag)
                        <div class="pr-4 py-3 basis-full md:basis-auto">
                            @php($tag_in_array = [$tag])
                            <x-tags-list :tags="$tag_in_array"></x-tags-list>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </x-layout.container>
</x-app-layout>

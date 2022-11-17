<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tags') }}
        </h1>
    </x-slot>

    <x-layout.container>
        <div class="ssnail-tags flex flex-wrap">
            @foreach($tags as $tag)
                <div class="pr-4 pb-4">
                    @php($tag_in_array = [$tag])
                    <x-tags-list :tags="$tag_in_array"></x-tags-list>
                </div>
            @endforeach
        </div>
    </x-layout.container>
</x-app-layout>

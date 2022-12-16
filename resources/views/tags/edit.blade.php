<x-app-layout>
    <?php
        if (is_null($tag ?? null)) {
            $title = 'Create tag';
            $action = route('tags.store');
        } else {
            $title = 'Edit tag';
            $action = route('tags.update', $tag);
        }
    ?>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __($title) }}
        </h1>
        <div>
            <a href="{{ route('tags.index') }}" class="mr-4 text-gray-500"><i class="fas fa-arrow-left"></i> <span class="text-sm">{{ __('See all the tags') }}</span></a>
        </div>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <x-form method="POST" action="{{ $action }}">
                <x-slot:title>
                    {{ __($title) }}
                </x-slot>

                @if(!is_null($tag ?? null))
                    {{ method_field('PUT') }}
                @endif

                <div class="col-span-6 sm:col-span-2">
                    <x-jet-label for="name" value="{{ __('Name') }}" />
                    <x-jet-input id="name" name="name" type="text" class="mt-1 block w-full" autocomplete="name" value="{{ old('name') ?? $tag->name ?? null }}"/>
                    <x-jet-input-error for="name" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-2">
                    <x-jet-label for="slug" value="{{ __('Slug') }}" />
                    <x-jet-input id="slug" name="slug" type="text" class="mt-1 block w-full" autocomplete="slug" value="{{ old('slug') ?? $tag->slug ?? null }}" />
                    <x-jet-input-error for="slug" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-2">
                    <x-jet-label for="locale" value="{{ __('Locale') }}" />
                    <x-jet-input id="locale" name="locale" type="text" class="mt-1 block w-full" autocomplete="locale" value="{{ old('locale') ?? $tag->locale ?? app()->getLocale() }}" />
                    <x-jet-input-error for="locale" class="mt-2" />
                </div>
            </x-form>
        </div>
    </div>
</x-app-layout>




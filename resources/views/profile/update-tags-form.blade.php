<x-jet-form-section submit="updateTags">
    <x-slot name="title">
        {{ __('Tags') }}
    </x-slot>

    <x-slot name="description">
        {{ __("Using tags you can appear on specific lists.") }}
        <br>
        {{ __("Lists can be anything you want to be recognised for: countries, sports, themes, interests, etc.") }}
        <br>
        {{ __("E.g. if you are Elon Musk, you could add \"billionare\" tag.") }}
    </x-slot>

    <x-slot name="form">
        <!-- Tags -->
        <div class="col-span-6">
            <x-jet-label value="{{ __('Tags') }}" />
        </div>
        @for($i = 0; $i < 5; $i++)
            <div class="col-span-6 sm:col-span-3 md:col-span-2 lg:col-span-1">
                @php($tag = $state['tags'][$i] ?? '')
                @livewire('tag-selector', ['tag' => $tag, 'tag_index' => $i], key('tag-selector-' . $i))
                <x-jet-input-error for="tags-{{ $i }}" class="mt-2" />
            </div>
        @endfor
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <x-jet-button>
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
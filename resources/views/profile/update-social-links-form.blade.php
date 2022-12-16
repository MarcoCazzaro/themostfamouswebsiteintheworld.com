<x-jet-form-section submit="updateSocialLinks">
    <x-slot name="title">
        {{ __('Social links') }}
    </x-slot>

    <x-slot name="description">
        {{ __("Add up to 3 social links.") }}
    </x-slot>

    <x-slot name="form">
        <!-- Social links -->
        <div class="col-span-6">
            <x-jet-label value="{{ __('Social') }}" />
        </div>
        @for($i = 0; $i < 3; $i++)
            <div class="col-span-6">
                @php($socialLink = $state['socialLinks'][$i] ?? '')
                @livewire('social-link-selector', ['socialLink' => $socialLink, 'linkIndex' => $i], key('social-link-selector-' . $i))
                <x-jet-input-error for="social-{{ $i }}" class="mt-2" />
            </div>
        @endfor
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Saved') }} <i class="fas fa-check"></i>
        </x-jet-action-message>

        <x-jet-button>
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
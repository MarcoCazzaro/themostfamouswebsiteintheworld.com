<div>
    <div class="flex items-center">
        <div class="w-8">
            @if($validLink)
                <a href="{{ $socialLink }}" rel="noopener nofollow" target="_blank" class="text-amber-500">
            @endif
                <i class="{{ $iconClass }}"></i>
            @if($validLink)
                </a>
            @endif
        </div>
        <x-jet-input
                type="url"
                class="mt-1 block w-full pl-4"
                wire:model.debounce.500ms="socialLink"
                placeholder="..."
                autocomplete="off"
                aria-label="Select social link"
                />
    </div>
</div>

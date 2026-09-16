<div x-data="{isTyped: false}">
    <div class="relative">
        <div class="relative before:content-['#'] before:absolute before:top-1/2 before:-translate-y-1/2 before:translate-x-1/2 before:text-gray-400">
            <x-input id="tag"
                type="text"
                class="mt-1 block w-full pl-4"
                wire:model.live.debounce.500ms="tag"
                placeholder="..."
                x-on:input.debounce.400ms="isTyped = ($event.target.value != '')"
                autocomplete="off"
                aria-label="Search tags"
                />
        </div>
        {{-- search box --}}
            <div x-show="isTyped" x-cloak>
                <div class="absolute w-full bg-amber-100 z-10 rounded">
                    @foreach($results as $result)
                        <div>
                            <ul>
                                <li>
                                    <button @click.prevent="$wire.selectTag('{{ $result->name }}');isTyped=false" class="text-sm pl-4 pr-3 py-2 hover:text-amber-600 break-words max-w-full">{{ $result->name }}</button>
                                </li>
                            </ul>
                        </div>
                    @endforeach
                </div>
            </div>
    </div>
</div>
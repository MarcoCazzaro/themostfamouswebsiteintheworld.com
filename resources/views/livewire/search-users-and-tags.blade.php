<div>
    <x-slot name="header">
        <div class="flex justify-between">
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Search users and tags') }}
            </h1>
        </div>
    </x-slot>

    <x-layout.container>
        <div class="w-full bg-white rounded-lg border border-gray-200 shadow-md">
            <div class="flex flex-col p-4 md:p-8">
                <div class="ssnail-search-box flex items-center mb-6">
                    <h2>Search: </h2>
                    <div class="relative grow ml-5">
                        <x-input id="searchStuff"
                            type="text"
                            class="mt-1 block w-full pl-4"
                            wire:model.live.debounce.500ms="stuff"
                            placeholder="..."
                            autocomplete="off"
                            aria-label="Search users and tags"
                            autofocus
                            />
                    </div>
                </div>
                <div wire:loading.delay>
                    <div class="text-center text-gray-400">
                        <i class="fas fa-rotate animate-spin"></i>
                    </div>
                </div>
                <div class="ssnail-users-and-tags flex flex-wrap">
                    <table class="table-auto border-separate border-spacing-2 w-full">
                        <tbody>
                            @foreach($found_stuff as $found_object)
                                @php($is_user = \Str::startsWith($found_object->ssnailkey, "users."))
                                <tr
                                    @can('supadupaadminshit')
                                    data-ssnail-id="{{ $found_object->ssnailkey }}"
                                    @endcan >
                                    <td>
                                        <a href="{{ $found_object->url ?? '' }}">
                                            @if($is_user)
                                                <img class="grow-0 shrink-0 w-6 h-6 lg:w-8 lg:h-8 object-cover rounded-full border border-amber-300 hover:border-amber-500 transition-all" src="{{ $found_object->profile_photo_url }}" alt="{{ $found_object->name }}">
                                            @else
                                                <span class="inline-flex justify-center items-center grow-0 shrink-0 w-6 h-6 lg:w-8 lg:h-8 rounded-full border border-amber-300 hover:border-amber-500 transition-all text-amber-400 font-bold">#</span>
                                            @endif
                                        </a>
                                    </td>
                                    <td>
                                        @if($is_user)
                                            <div class="ssnail-points text-xs inline-flex items-center justify-end w-full">
                                                <span>{{ $found_object->famous_points_received_human }}</span>
                                                <x-application-logo class="inline h-3 w-auto ml-1" />
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ $found_object->url ?? '' }}" class="hover:underline">
                                            {{ $found_object->name }}
                                            <div class="text-xs md:hidden">
                                            @if($is_user)
                                                <span class="before:content-['@']">{{ $found_object->slug }}</span>
                                            @else
                                                <span class="before:content-['#']">{{ $found_object->slug }}</span>
                                            @endif
                                            </div>
                                        </a>
                                    </td>
                                    <td class="hidden md:table-cell">
                                        <a href="{{ $found_object->url ?? '' }}" class="hover:underline">
                                            @if($is_user)
                                                <span class="before:content-['@']">{{ $found_object->slug }}</span>
                                            @else
                                                <span class="before:content-['#']">{{ $found_object->slug }}</span>
                                            @endif
                                        </a>
                                    </td>
                                    <td>
                                        <div class="flex justify-end">
                                            @canImpersonate($guard = null)
                                                <a href="{{ route('impersonate', $found_object->id) }}" class="mr-3"><i class="fas fa-mask"></i> <span class="hidden lg:inline text-sm">{{ __('Impersonate') }}</span></a>
                                            @endCanImpersonate
                                            @can('supadupaadminshit')
                                                <a href="{{ route('users.edit', $found_object ?? null) }}" class="mr-3"><i class="fas fa-pen-to-square"></i> <span class="hidden lg:inline text-sm">{{ __('Edit') }}</span></a>
                                                <x-delete-model :user="$found_object" label-class="hidden lg:inline text-sm"></x-delete-model>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </x-layout.container>
</div>

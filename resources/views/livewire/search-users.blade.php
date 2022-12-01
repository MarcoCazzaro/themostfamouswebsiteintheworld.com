<div>
    <x-slot name="header">
        <div class="flex justify-between">
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Search users') }}
            </h1>
        </div>
    </x-slot>

    <x-layout.container>
        <div class="w-full bg-white rounded-lg border border-gray-200 shadow-md">
            <div class="flex flex-col p-4 md:p-8">
                <div class="ssnail-search-box flex items-center mb-6">
                    <h2>Search: </h2>
                    <div class="relative grow ml-5">
                        <x-jet-input id="searchStuff"
                            type="text"
                            class="mt-1 block w-full pl-4"
                            wire:model.debounce.500ms="stuff"
                            placeholder="..."
                            autocomplete="off"
                            aria-label="Search users"
                            autofocus
                            />
                    </div>
                </div>
                <div class="ssnail-users flex flex-wrap">
                    <table class="table-auto border-separate border-spacing-2 w-full" wire:loading.class="animate-pulse">
                        <tbody>
                            @foreach($found_users as $user)
                                <tr
                                    @can('supadupaadminshit')
                                    data-ssnail-id="{{ $user->id }}"
                                    @endcan >
                                    <td class="hidden md:table-cell">
                                        <a href="{{ $user->url ?? '' }}">
                                            <img class="grow-0 shrink-0 w-4 h-4 lg:w-8 lg:h-8 object-cover rounded-full border border-amber-300 hover:border-amber-500 transition-all" src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}">
                                        </a>
                                    </td>
                                    <td>
                                        <div class="ssnail-points text-xs inline-flex items-center justify-end w-full">
                                            <span>{{ $user->total_famous_points }}</span>
                                            <x-jet-application-logo class="inline h-3 w-auto ml-1" />
                                        </div>
                                    </td>
                                    <td><a href="{{ $user->url ?? '' }}" class="hover:underline">{{ $user->name }}</a></td>
                                    <td class="hidden md:table-cell">{{ $user->slug }}</td>
                                    <td>
                                        <div class="flex justify-end">
                                            <a href="{{ route('users.show', $user ?? null) }}" class="mr-3 text-amber-500"><i class="fas fa-eye"></i> <span class="hidden lg:inline text-sm">{{ __('View') }}</span></a>
                                            @canImpersonate($guard = null)
                                                <a href="{{ route('impersonate', $user->id) }}" class="mr-3"><i class="fas fa-mask"></i> <span class="hidden lg:inline text-sm">{{ __('Impersonate') }}</span></a>
                                            @endCanImpersonate
                                            @can('supadupaadminshit')
                                                <a href="{{ route('users.edit', $user ?? null) }}" class="mr-3"><i class="fas fa-pen-to-square"></i> <span class="hidden lg:inline text-sm">{{ __('Edit') }}</span></a>
                                                <x-delete-model :user="$user" label-class="hidden lg:inline text-sm"></x-delete-model>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($found_users->count() > 0)
                    {{ $found_users->links() }}
                @endif
            </div>
        </div>
    </x-layout.container>
</div>

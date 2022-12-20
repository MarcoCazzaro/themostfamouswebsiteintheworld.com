<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Your statuses') }}
            </h1>
            <div class="h-100 items-center">
                <a href="{{ route('statuses.create') }}" class="text-amber-500"><i class="fas fa-plus"></i> {{ __('Add Status') }}</a>
            </div>
        </div>
    </x-slot>

    <x-layout.container>
        @if($statuses->count() > 0)
            <div class="w-full bg-white rounded-lg border border-gray-200 shadow-md">
                <div class="flex flex-col p-6">
                    <div class="ssnail-statuses flex flex-wrap">
                        @foreach($statuses as $status)
                            <div class="flex justify-between w-full [&:not(:last-child)]:mb-4">
                                <div class="ssnail-status-body">
                                    <div class="text-gray-500 text-xs">
                                        @if($status->isCurrent)
                                            <span class="inline-block mb-2 text-green-500 text-xs uppercase border border-green-500 rounded px-1 py-0.5 mr-1">{{ __('Current') }} <i class="fas fa-check"></i></span>
                                        @endif
                                        {{ $status->updated_at->toDateTimeString() }}
                                    </div>
                                    {{ $status->excerpt }}
                                </div>
                                <div class="ssnail-actions ml-4 w-18">
                                    <a href="{{ route('statuses.edit', $status ?? null) }}" class="mr-3 text-amber-500"><i class="fas fa-pen-to-square"></i> {{ __('Edit') }}</a>
                                    <x-delete-model :status="$status"></x-delete-model>
                                </div>
                            </div>
                            @if($status->isCurrent && $statuses->count() > 1)
                                <hr class="w-full mb-4 h-px bg-gray-200 border-0 dark:bg-gray-700">
                            @endif
                        @endforeach
                    </div>
                    {{ $statuses->links() }}
                </div>
            </div>
        @else
            <p>{{ __('Click here to add a status:') }} <a href="{{ route('statuses.create') }}" class="text-amber-500"><i class="fas fa-plus"></i> {{ __('Add Status') }}</a></p>
        @endif
    </x-layout.container>
</x-app-layout>

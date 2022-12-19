<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <div class="flex items-center flex-wrap">
                <div class="basis-full sm:basis-auto mr-0 sm:mr-8">
                    <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                        @if($status->isCurrent)
                            {{ __('Your current status') }}
                        @else
                            {{ __('Your status on') }} {{ $status->updated_at->toDateTimeString() }}
                        @endif
                    </h1>
                    <div>
                        <a href="{{ route('statuses.index') }}" class="mr-4 text-gray-500"><i class="fas fa-arrow-left"></i> <span class="text-sm">{{ __('See your statuses') }}</span></a>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>


    <x-layout.container>
        <div class="ssnail-status">
            <div class="w-full bg-white rounded-lg border border-gray-200 shadow-md">
                <div class="flex flex-col p-6">
                    {{ $status->body }}
                </div>
            </div>
        </div>
    </x-layout.container>
</x-app-layout>

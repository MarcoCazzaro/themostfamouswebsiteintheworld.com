<x-app-layout>
    <?php
        if (is_null($status ?? null)) {
            $action = route('statuses.store');
        } else {
            $action = route('statuses.update', $status);
        }
    ?>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Status') }}
        </h1>
        <div>
            <a href="{{ route('statuses.index') }}" class="mr-4 text-gray-500"><i class="fas fa-arrow-left"></i> <span class="text-sm">{{ __('See your statuses') }}</span></a>
        </div>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <x-form method="POST" action="{{ $action }}">
                <x-slot:title>
                    {{ __('Update your status message') }}
                </x-slot>

                @if(!is_null($status ?? null))
                    {{ method_field('PUT') }}
                @endif

                <div class="col-span-6">
                    <x-jet-input id="body" name="body" type="text" class="block w-full" autocomplete="body" value="{{ old('body') ?? $status->body ?? null }}"/>
                    <x-jet-input-error for="body" class="mt-2" />
                </div>
            </x-form>
        </div>
    </div>
</x-app-layout>
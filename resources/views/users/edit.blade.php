<x-app-layout>
    <?php
        if (is_null($user ?? null)) {
            $title = 'Create user';
            $action = route('users.store');
        } else {
            $title = 'Edit user';
            $action = route('users.update', $user);
        }
    ?>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __($title) }}
        </h1>
        <div>
            <a href="{{ route('users.index') }}" class="mr-4 text-gray-500"><i class="fas fa-arrow-left"></i> <span class="text-sm">{{ __('See all the users') }}</span></a>
        </div>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <x-form method="POST" action="{{ $action }}">
                <x-slot:title>
                    {{ __($title) }}
                </x-slot>

                @if(!is_null($user ?? null))
                    {{ method_field('PUT') }}
                @endif

                <div class="col-span-6 sm:col-span-3">
                    <x-jet-label for="name" value="{{ __('Name') }}" />
                    <x-jet-input id="name" name="name" type="text" class="mt-1 block w-full" autocomplete="name" value="{{ old('name') ?? $user->name ?? null }}"/>
                    <x-jet-input-error for="name" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-3">
                    <x-jet-label for="email" value="{{ __('Email') }}" />
                    <x-jet-input id="email" name="email" type="email" class="mt-1 block w-full" autocomplete="email" value="{{ old('email') ?? $user->email ?? null }}"/>
                    <x-jet-input-error for="email" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-3">
                    <x-jet-label for="slug" value="{{ __('Slug') }}" />
                    <x-jet-input id="slug" name="slug" type="text" class="mt-1 block w-full" autocomplete="slug" value="{{ old('slug') ?? $user->slug ?? null }}" />
                    <x-jet-input-error for="slug" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-3">
                    <x-jet-label for="password" value="{{ __('Password') }}" />
                    <x-jet-input id="password" name="password" type="password" class="mt-1 block w-full" />
                    <x-jet-input-error for="password" class="mt-2" />
                </div>
            </x-form>
        </div>
    </div>
</x-app-layout>




<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Users') }}
            </h1>
            @can('supadupaadminshit')
                <div class="h-100 items-center">
                    <a href="{{ route('users.create') }}"><i class="fas fa-plus"></i> {{ __('Add User') }}</a>
                </div>
            @endcan
        </div>
    </x-slot>

    <x-layout.container>
        <div class="w-full bg-white rounded-lg border border-gray-200 shadow-md">
            <div class="flex flex-col p-6">
                <div class="ssnail-users flex flex-wrap mt-6">
                    <table class="table-auto border-separate border-spacing-2 w-full">
                        <thead>
                            <tr class="text-left text-amber-500">
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Slug</th>
                                <th class="text-right">Operations</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td><a href="{{ route('users.show', $user) }}" class="underline">{{ $user->name }}</a></td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->slug }}</td>
                                    <td>
                                        <div class="flex justify-end">
                                            <a href="{{ route('users.edit', $user ?? null) }}" class="mr-3"><i class="fas fa-pen-to-square"></i> {{ __('Edit') }}</a>
                                            <x-delete-model :user="$user"></x-delete-model>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $users->links() }}
            </div>
        </div>
    </x-layout.container>
</x-app-layout>

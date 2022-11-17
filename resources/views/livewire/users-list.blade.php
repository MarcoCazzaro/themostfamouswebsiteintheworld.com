<div>
    @php($list_users = $ranked_users ?? $currentUsers ?? false)
    @if($list_users)
        <div class="inline-grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 py-8 justify-center w-full">
            @foreach($list_users as $current_user)
                <div class="px-4 md:px-0 min-w-fit">
                    @include('partials.user-card', ['user' => $current_user])
                </div>
            @endforeach
        </div>

        @if($ranked_users ?? false)
            {{ $ranked_users->links() }}
        @endif
    @endif
</div>

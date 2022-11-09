<div>
    @if($currentUsers ?? false)
        <div class="inline-grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4 py-8 justify-center w-full">
            @foreach($currentUsers as $current_user)
                <div class="px-16 md:px-0 min-w-fit">
                    @include('partials.user-card', ['user' => $current_user])
                </div>
            @endforeach
        </div>
    @endif
</div>

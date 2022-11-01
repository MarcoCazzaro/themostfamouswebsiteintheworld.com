@if($currentUsers ?? false)
    @foreach($currentUsers as $current_user)
        <div class="px-16 md:px-0 min-w-fit">
            @include('partials.user-card', ['user' => $current_user])
        </div>
    @endforeach
@endif
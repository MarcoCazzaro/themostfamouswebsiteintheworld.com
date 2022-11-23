<div class="flex flex-wrap">
    @foreach($tags as $tag)
        <a href="{{ route(($route ?? 'users.most-famous-people.show'), $tag) }}">
            <div class="ssnail-tag mr-2 text-sm text-amber-500 hover:text-amber-700 before:content-['#']">
                {{ $tag->name }}
                @if($tag->users_count ?? false)
                    <span class="ssnail-count mr-2 inline-flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-[9px]">{{ humanNumber($tag->users_count) }}</span>
                @endif
            </div>
        </a>
    @endforeach
</div>
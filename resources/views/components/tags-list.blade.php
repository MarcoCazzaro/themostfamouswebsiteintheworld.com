<div class="flex flex-wrap">
    @foreach($tags as $tag)
        <a href="{{ route('tags.show', $tag) }}">
            <div class="ssnail-tag mr-2 text-sm text-amber-500 hover:text-amber-700 before:content-['#']">
                {{ $tag->name }}
                @if($tag->users_count ?? false)
                    <span class="ssnail-count mr-2 inline-flex items-center justify-center w-8 h-8 scale-75 bg-amber-500 text-white rounded-full text-xs">{{ humanNumber($tag->users_count) }}</span>
                @endif
            </div>
        </a>
    @endforeach
</div>
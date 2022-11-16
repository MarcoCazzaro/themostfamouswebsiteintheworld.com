<div class="flex">
    @foreach($tags as $tag)
        <div class="ssnail-tag mr-2 text-sm text-amber-500 before:content-['#']">{{ $tag->name }}</div>
    @endforeach
</div>
<div wire:init="loadRankings">
    <div wire:loading>
        <div class="text-center text-gray-400">
            <i class="fas fa-rotate animate-spin"></i>
        </div>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-5 gap-4">
        <div class="p-8 flex flex-wrap justify-center items-center col-span-1 lg:col-span-2 xl:col-span-5">
            <h4 class="font-semibold basis-full text-center mb-4">{{ __('Global') }} <a href="{{ route('users.most-famous-people') }}"><i class="fas fa-up-right-from-square fa-xs"></i></a></h4>
            <div class="ssnail-position rounded-full text-white bg-amber-500 text-2xl flex justify-center items-center font-bold w-14 h-14">
                {{ $global_position ?? 'n.a.' }}
            </div>
        </div>
        @for($i = 0; $i < 5; $i++)
            <div class="p-8 flex flex-wrap justify-center items-center">
                @php($tag = $user->tags->get($i) ?? false)
                @if($tag)
                    <h4 class="flex items-end justify-center font-semibold basis-full text-center break-all h-20 mb-2 overflow-hidden"><a href="{{ route('users.most-famous-people.show', $tag) }}">#{{ $tag->name }} <i class="fas fa-up-right-from-square fa-xs"></i></a></h4>
                    <div class="ssnail-position rounded-full text-amber-500 bg-white border-2 border-amber-500 text-2xl flex justify-center items-center font-bold w-14 h-14">
                        {{ ${$tag->slug . '_position'} ?? 'n.a.' }}
                    </div>
                @endif
            </div>
        @endfor
    </div>
</div>

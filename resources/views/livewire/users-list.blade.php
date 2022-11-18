<div>
    @php($list_users = $ranked_users ?? $currentUsers ?? false)
    @if($list_users)
        <div class="inline-grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 py-8 justify-center w-full">
            @foreach($list_users as $key => $current_user)
                <?php
                    $col_span_class = "";
                    $highlight_user = false;
                    if (isset($first_element_index)) {
                        $element_index = $key + $first_element_index;
                        if ($highlightFirst && $element_index === 1) {
                            $col_span_class = "col-span-full";
                            $highlight_user = true;
                        }
                    } else {
                        $element_index = null;
                        if ($highlightFirst && $key === 0) {
                            $col_span_class = "col-span-full";
                            $highlight_user = true;
                        }
                    }
                ?>
                <div class="px-4 md:px-0 min-w-fit {{ $col_span_class }}">
                    @include('partials.user-card', [
                        'user' => $current_user,
                        'element_index' => $element_index,
                        'highlight_user' => $highlight_user
                    ])
                </div>
            @endforeach
        </div>

        @if($ranked_users ?? false)
            {{ $ranked_users->links() }}
        @endif
    @endif
</div>

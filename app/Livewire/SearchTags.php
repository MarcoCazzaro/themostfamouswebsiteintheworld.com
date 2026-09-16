<?php

namespace App\Livewire;

use App\Models\Tag;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class SearchTags extends Component
{
    use AuthorizesRequests;

    public $stuff;

    public function mount($stuff = null)
    {
        $this->stuff = $stuff;
    }

    public function render()
    {
        $this->authorize('supadupaadminshit');

        $found_stuff = collect([]);
        $found_tags_starts_with = null;
        $found_tags_contains = null;
        if ($this->stuff) {
            $search_string = $this->stuff;
            $search_string = ltrim($search_string, '#');
            $found_tags_starts_with = Tag::selectRaw("tags.*, CONCAT('tags.', id) AS ssnailkey")->where('name', 'like', $search_string.'%')
                ->orderBy('name', 'asc')
                ->take(50)
                ->get();
            $found_tags_contains = Tag::selectRaw("tags.*, CONCAT('tags.', id) AS ssnailkey")->where('name', 'like', '%'.$search_string.'%')
                ->orderByFamousPointsReceived()
                ->take(50)
                ->get();
            if ($found_tags_starts_with) {
                $found_stuff = $found_stuff->merge($found_tags_starts_with);
            }
            if ($found_tags_contains) {
                $found_stuff = $found_stuff->merge($found_tags_contains);
            }
            $found_stuff = $found_stuff->unique('ssnailkey');
        }

        return view('livewire.search-tags', compact('found_stuff'));
    }
}

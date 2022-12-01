<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Tag;

class SearchUsersAndTags extends Component
{
    public $stuff;

    public function mount($stuff = null)
    {
        $this->stuff = $stuff;
    }

    public function render()
    {
        $found_stuff = collect([]);
        $found_users_starts_with = null;
        $found_users_contains = null;
        $found_tags_starts_with = null;
        $found_tags_contains = null;
        if ($this->stuff) {
            $search_string = $this->stuff;
            if (!\Str::startsWith($search_string, '#')) {
                $found_users_starts_with = User::selectRaw("users.*, CONCAT('users.', id) AS ssnailkey")->where('name', 'like', $search_string . '%')
                    ->orderBy('name', 'asc')
                    ->take(20)
                    ->get();

                $found_users_contains = User::selectRaw("users.*, CONCAT('users.', id) AS ssnailkey")->where('name', 'like', '%' . $search_string . '%')
                    ->orderByFamousPointsReceived()
                    ->take(20)
                    ->get();
            }
            $search_string = ltrim($search_string, '#');
            $found_tags_starts_with = Tag::selectRaw("tags.*, CONCAT('tags.', id) AS ssnailkey")->where('name', 'like', $search_string . '%')
                ->orderBy('name', 'asc')
                ->take(20)
                ->get();
            $found_tags_contains = Tag::selectRaw("tags.*, CONCAT('tags.', id) AS ssnailkey")->where('name', 'like', '%' . $search_string . '%')
                ->orderByFamousPointsReceived()
                ->take(20)
                ->get();
            if ($found_users_starts_with) {
                $found_stuff = $found_stuff->merge($found_users_starts_with);
            }
            if ($found_tags_starts_with) {
                $found_stuff = $found_stuff->merge($found_tags_starts_with);
            }
            if ($found_users_contains) {
                $found_stuff = $found_stuff->merge($found_users_contains);
            }
            if ($found_tags_contains) {
                $found_stuff = $found_stuff->merge($found_tags_contains);
            }
            $found_stuff = $found_stuff->unique('ssnailkey');
        }
        return view('livewire.search-users-and-tags', compact('found_stuff'));
    }
}

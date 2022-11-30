<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;

class SearchUsers extends Component
{
    use WithPagination;

    public $stuff;

    public function mount($stuff = null)
    {
        $this->stuff = $stuff;
    }

    public function render()
    {
        if ($this->stuff) {
            $found_users = User::where('name', 'like', $this->stuff . '%')
                ->orderBy('slug', 'asc')
                ->union(
                    User::where('name', 'like', '%' . $this->stuff . '%')
                        ->orderBy('slug', 'asc')
                )
                ->paginate(50);
        } else {
            $found_users = collect([]);
        }
        return view('livewire.search-users', compact('found_users'));
    }
}

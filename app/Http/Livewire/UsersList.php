<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

class UsersList extends Component
{
    use WithPagination;

    public $currentUsers;
    public $highlightFirst;
    public $showPosition;
    public $tag;

    public function render()
    {
        if (isset($this->tag) && $this->tag) {
            $ranked_users = User::orderByFamousPointsReceived()
                ->whereHas('tags', function($query){
                    $query->where('tags.id', $this->tag->id);
                })
                ->paginate(33);
            return view('livewire.users-list', [
                'ranked_users' => $ranked_users,
                'first_element_index' => $ranked_users->firstItem()
            ]);
        } else {
            return view('livewire.users-list');
        }
    }
}

<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class UsersList extends Component
{
    use WithPagination;

    public $currentUsers;
    public $tag;

    public function render()
    {
        if (isset($this->tag) && $this->tag) {
            $ranked_users = $this->tag->ranking()->paginate(33);
            return view('livewire.users-list', ['ranked_users' => $ranked_users]);
        } else {
            return view('livewire.users-list');
        }
    }
}

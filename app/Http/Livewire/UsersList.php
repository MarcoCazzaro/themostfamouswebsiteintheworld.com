<?php

namespace App\Http\Livewire;

use Livewire\Component;

class UsersList extends Component
{
    public $currentUsers;

    public function render()
    {
        return view('livewire.users-list');
    }
}

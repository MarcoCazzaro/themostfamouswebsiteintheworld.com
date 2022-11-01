<?php

namespace App\View\Components;

use Illuminate\View\Component;
use \App\Models\User;

class UsersGrid extends Component
{
    public $currentUsers;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(User $currentUsers)
    {
        $this->currentUsers = $currentUsers;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.layout.users-grid');
    }
}

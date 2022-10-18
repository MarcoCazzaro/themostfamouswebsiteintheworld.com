<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Jobs\Worship;

class IncrementFamousness extends Component
{
    public User $user;
    public $famous_points = 1;

    public function mount()
    {
        $this->famous_points = $this->user->total_famous_points;
    }

    public function render()
    {
        return view('livewire.increment-famousness');
    }

    public function hydrate() {
        $this->famous_points++;
        if (app()->environment() === 'local') {
            Worship::dispatchSync(auth()->user(), $this->user);
        } else {
            Worship::dispatch(auth()->user(), $this->user);
        }
    }
}

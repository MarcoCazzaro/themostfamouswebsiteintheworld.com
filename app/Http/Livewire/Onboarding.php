<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Onboarding extends Component
{
    public $shown;

    protected $listeners = ['openOnboarding'];

    public function mount()
    {
        $this->shown = filter_var(getUserOption('onboarding.shown'), FILTER_VALIDATE_BOOLEAN);
    }

    public function render()
    {
        return view('livewire.onboarding');
    }

    public function okGotIt()
    {
        setUserOption('onboarding.shown', 1);
    }

    public function openOnboarding()
    {
        $this->shown = true;
        $this->dispatchBrowserEvent('open-onboarding');
    }
}

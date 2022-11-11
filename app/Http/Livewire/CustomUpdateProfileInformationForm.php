<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Laravel\Jetstream\Http\Livewire\UpdateProfileInformationForm;

class CustomUpdateProfileInformationForm extends UpdateProfileInformationForm
{
    protected $listeners = ['tagSelected'];

    /**
     * Prepare the component.
     *
     * @return void
     */
    public function mount()
    {
        $this->state = Auth::user()->withoutRelations()->toArray();
        $this->state['tags'] = Auth::user()->tags->pluck('slug')->implode(' ');
    }

    public function tagSelected($tag_name)
    {
        $this->state['tags'] = $tag_name;
        \Log::info("Selecting tag: " . $tag_name);
    }
}

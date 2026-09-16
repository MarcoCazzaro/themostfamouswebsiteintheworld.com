<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;
use Laravel\Jetstream\Http\Livewire\UpdateProfileInformationForm;

class ProfileUpdateSocialLinksForm extends UpdateProfileInformationForm
{
    protected function getListeners()
    {
        $listeners = [];
        for ($i = 0; $i < 5; $i++) {
            $listeners['linkSelected:'.$i] = 'linkSelected';
        }
        return $listeners;
    }

    /**
     * Prepare the component.
     *
     * @return void
     */
    public function mount()
    {
        $this->state = Auth::user()->withoutRelations()->toArray();
        $this->state['socialLinks'] = array_pad(Auth::user()->socialLinks->pluck('value')->toArray(), 3, null);
    }

    public function render()
    {
        return view('profile.update-social-links-form');
    }

    public function linkSelected($link, $link_index)
    {
        $this->state['socialLinks'][$link_index] = $link;
    }

    public function updateSocialLinks(UpdatesUserProfileInformation $updater)
    {
        $this->resetErrorBag();
        $updater->update(
            Auth::user(),
            $this->state
        );
        $this->dispatch('saved');
        $this->dispatch('refresh-navigation-menu');
    }
}

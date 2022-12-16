<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Laravel\Jetstream\Http\Livewire\UpdateProfileInformationForm;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class ProfileUpdateSocialLinksForm extends UpdateProfileInformationForm
{
    protected function getListeners()
    {
        $listeners = [];
        for ($i=0; $i < 5; $i++) {
            $listeners['linkSelected:' . $i] = 'linkSelected';
        }
        return $listeners;
    }

    private function refreshFromDB() {
        $this->state = [
            'socialLinks' => array_pad(Auth::user()->socialLinks->pluck('value')->toArray(), 3, null)
        ];
    }

    /**
     * Prepare the component.
     *
     * @return void
     */
    public function mount()
    {
        $this->refreshFromDB();
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
        $this->refreshFromDB();
        $this->emit('saved', $this->state['socialLinks']);
        $this->emit('refresh-navigation-menu');
    }
}

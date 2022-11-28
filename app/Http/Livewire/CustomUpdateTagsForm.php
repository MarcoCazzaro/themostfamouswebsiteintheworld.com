<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Laravel\Jetstream\Http\Livewire\UpdateProfileInformationForm;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class CustomUpdateTagsForm extends UpdateProfileInformationForm
{
    protected function getListeners()
    {
        $listeners = [];
        for ($i=0; $i < 5; $i++) {
            $listeners['tagSelected:' . $i] = 'tagSelected';
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
        $this->state['tags'] = array_pad(Auth::user()->tags->pluck('name')->toArray(), 5, null);
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('profile.update-tags-form');
    }

    public function tagSelected($tag_name, $tag_index)
    {
        $this->state['tags'][$tag_index] = $tag_name;
    }

    public function updateTags(UpdatesUserProfileInformation $updater)
    {
        $this->resetErrorBag();
        $updater->update(
            Auth::user(),
            $this->state
        );
        $this->emit('saved');
        $this->emit('refresh-navigation-menu');
    }

    /**
     * Update the user's profile information.
     *
     * @param  \Laravel\Fortify\Contracts\UpdatesUserProfileInformation  $updater
     * @return void
     */
    public function updateProfileInformation(UpdatesUserProfileInformation $updater)
    {
        $this->resetErrorBag();

        $updater->update(
            Auth::user(),
            $this->photo
                ? array_merge($this->state, ['photo' => $this->photo])
                : $this->state
        );

        if (isset($this->photo)) {
            return redirect()->route('profile.show');
        }

        $this->emit('saved');

        $this->emit('refresh-navigation-menu');
    }
}

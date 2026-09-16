<?php

namespace App\Livewire;

use Livewire\Component;

class SocialLinkSelector extends Component
{
    public $iconClass;

    public $socialLink;

    public $validLink;

    public $linkIndex;

    protected $listeners = ['saved' => 'refreshLink'];

    public function render()
    {
        $iconClass = '';
        foreach (supportedSocialPlatforms() as $socialName) {
            if (stripos($this->socialLink, $socialName) !== false) {
                $iconClass = 'text-amber-500 fa-lg fab fa-'.$socialName;
            }
        }
        if ($iconClass === '' && strlen(trim($this->socialLink)) > 0) {
            $iconClass = 'text-red-500 fa-lg fas fa-question';
            $this->validLink = false;
        } else {
            $this->validLink = true;
            $this->emitUp('linkSelected:'.$this->linkIndex, $this->socialLink, $this->linkIndex);
        }
        $this->iconClass = $iconClass;

        return view('livewire.social-link-selector');
    }

    public function refreshLink($socialLinks = null)
    {
        if (!is_null($socialLinks)) {
            if ($socialLinks && isset($socialLinks[$this->linkIndex ?? -1])) {
                $this->socialLink = $socialLinks[$this->linkIndex];
            }
        }
    }
}

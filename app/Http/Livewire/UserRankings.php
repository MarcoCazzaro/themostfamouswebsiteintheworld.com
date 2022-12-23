<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Repositories\CacheRepository;

class UserRankings extends Component
{
    public $readyToLoad = false;
    public $user;

    public function loadRankings()
    {
        $this->readyToLoad = true;
    }

    public function render(CacheRepository $cache)
    {
        $data = [];
        if ($this->readyToLoad) {
            $data['global_position'] = $this->user->getGlobalRankingPosition($cache);
            foreach ($this->user->tags as $tag) {
                $data[$tag->slug . '_position'] = $this->user->getTagRankingPosition($tag->id, $cache);
            }
        }
        return view('livewire.user-rankings', $data);
    }
}

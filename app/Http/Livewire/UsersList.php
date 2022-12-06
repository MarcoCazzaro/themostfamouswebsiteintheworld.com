<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

class UsersList extends Component
{
    use WithPagination;

    public $readyToLoad = false;
    public $users;
    public $highlightFirst;
    public $showPosition;
    public $tag;

    public function loadUsers()
    {
        $this->readyToLoad = true;
    }
    public function render()
    {
        $data = [];
        if ($this->readyToLoad) {
            if (isset($this->tag) && $this->tag) {
                $ranked_users = User::orderByFamousPointsReceived()
                    ->whereHas('tags', function($query){
                        $query->where('tags.id', $this->tag->id);
                    })
                    ->take(999)
                    ->paginate(33);
                $data = [
                    'ranked_users' => $ranked_users,
                    'first_element_index' => $ranked_users->firstItem()
                ];
            } else {
                $data['loaded_users'] = $this->users;
            }
        }
        return view('livewire.users-list', $data);
    }
}

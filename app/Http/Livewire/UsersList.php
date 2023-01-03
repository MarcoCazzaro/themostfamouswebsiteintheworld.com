<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Repositories\CacheRepository;
use Livewire\Component;
use Livewire\WithPagination;

class UsersList extends Component
{
    use WithPagination;

    public $readyToLoad = false;

    public $users;

    public $highlightFirst;

    public $showPosition;

    public $tag_id;

    public $scope;

    public function loadUsers()
    {
        $this->readyToLoad = true;
    }

    public function render(CacheRepository $cache)
    {
        $data = [];
        if ($this->readyToLoad) {
            switch ($this->scope) {
                case 'most_famous_people' :
                    $data['loaded_users'] = $cache->most_famous_users('people', 113);
                    break;
                case 'most_famous_people_welcome' :
                    $data['loaded_users'] = $cache->most_famous_users('people');
                    break;
                case 'most_famous_fans' :
                    $data['loaded_users'] = $cache->most_famous_users('fans', 113);
                    break;
                case 'latest_users' :
                    $data['loaded_users'] = $cache->latest_users();
                    break;
                case 'full_ranking_of_people_by_tag':
                    if (isset($this->tag_id) && $this->tag_id) {
                        $ranked_users = User::orderByFamousPointsReceived()
                            ->whereHas('tags', function ($query) {
                                $query->where('tags.id', $this->tag_id);
                            })
                            ->take(999)
                            ->paginate(33);
                        $data = [
                            'ranked_users' => $ranked_users,
                            'first_element_index' => $ranked_users->firstItem(),
                        ];
                    }
                    break;

                default:
                    $data['loaded_users'] = $this->users;
                    break;
            }
        }

        return view('livewire.users-list', $data);
    }
}

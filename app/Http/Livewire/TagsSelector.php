<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Tag;

class TagsSelector extends Component
{
    public $tags;

    public function render()
    {
        $search_string = $this->tags;
        if (!is_null($this->tags)) {
            $results = Tag::where('name', 'LIKE', '%' . $this->tags . '%')
                ->take(13)
                ->get();
        } else {
            $results = [];
        }
        $this->emitUp('tagSelected', $search_string);
        return view('livewire.tags-selector', [
            'results' => $results,
        ]);
    }

    public function selectTag($tag_name) {
        $this->tags = $tag_name;
        $this->emitUp('tagSelected', $tag_name);
    }
}

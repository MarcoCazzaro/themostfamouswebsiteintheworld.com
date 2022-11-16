<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Tag;

class TagSelector extends Component
{
    public $tag;
    public $tag_index;

    public function render()
    {
        $search_string = $this->tag;
        if (!is_null($this->tag)) {
            $results = Tag::where('name', 'LIKE', '%' . $this->tag . '%')
                ->take(13)
                ->get();
        } else {
            $results = [];
        }
        $this->emitUp('tagSelected:' . $this->tag_index, $search_string, $this->tag_index);
        return view('livewire.tag-selector', [
            'results' => $results,
        ]);
    }

    public function selectTag($tag_name) {
        $this->tag = $tag_name;
        $this->emitUp('tagSelected:' . $this->tag_index, $tag_name, $this->tag_index);
    }
}

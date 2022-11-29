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
        $this->tag = formatTagName($this->tag);
        $search_string = $this->tag;
        if (!empty($search_string)) {
            $results = Tag::where('name', 'LIKE', $this->tag . '%')
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
        $this->tag = formatTagName($tag_name);
        $this->emitUp('tagSelected:' . $this->tag_index, $this->tag, $this->tag_index);
    }
}

<?php

//https://devdojo.com/tnylea/laravel-livewire-trix-editor-component

namespace App\Http\Livewire;

use Livewire\Component;

class WysiwygEditor extends Component
{
    public $fieldName;

    public $value;

    public $editorId;

    public function mount($value = '')
    {
        $this->value = $value;
        $this->editorId = 'ssnail-w-editor-'.uniqid();
    }

    public function render()
    {
        return view('livewire.wysiwyg-editor');
    }
}

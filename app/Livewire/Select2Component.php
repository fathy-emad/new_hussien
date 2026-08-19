<?php

namespace App\Livewire;

use Livewire\Component;

class Select2Component extends Component {

    public $selectedOption;
    public $options;

    public function mount() {
        $this->options = [ 'Category', 'Angular', 'Node Js', 'React', 'Python' ];
    }

    public function render() {

        return view( 'livewire.select2-component' );
    }
}

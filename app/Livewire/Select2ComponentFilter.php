<?php

namespace App\Livewire;

use Livewire\Component;

class Select2ComponentFilter extends Component {
    public $selectedOption;
    public $options;

    public function mount() {
        $this->options1 = [ 'Newly published', 'Angular', 'Nodejs', 'React' ];
    }

    public function render() {
        return view( 'livewire.select2-component-filter' );
    }
}

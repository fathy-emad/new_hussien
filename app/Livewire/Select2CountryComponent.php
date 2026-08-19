<?php

namespace App\Livewire;

use Livewire\Component;

class Select2CountryComponent extends Component {
    public $selectedOption;
    public $options;

    public function mount() {
        $this->options = [ 'Select country', 'India', 'America', 'London' ];
    }

    public function render() {
        return view( 'livewire.select2-country-component', );
    }
}

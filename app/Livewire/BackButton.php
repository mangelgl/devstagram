<?php

namespace App\Livewire;

use Livewire\Component;

class BackButton extends Component
{
    public $width = 'md:w-1/2';

    public function render()
    {
        return view('livewire.back-button');
    }
}

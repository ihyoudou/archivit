<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Flash extends Component
{
    protected $listeners = [
        'itemAdded' => '$refresh',
        'itemRemoved' => '$refresh',
    ];

    public function render()
    {
        return view('livewire.flash');
    }
}

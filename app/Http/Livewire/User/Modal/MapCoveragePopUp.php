<?php

namespace App\Http\Livewire\User\Modal;

use Livewire\Component;

class MapCoveragePopUp extends Component
{
    public $model;
    public function render()
    {
        return view('livewire.user.modal.map-coverage-pop-up');
    }
}

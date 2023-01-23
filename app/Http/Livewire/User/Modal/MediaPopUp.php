<?php

namespace App\Http\Livewire\User\Modal;

use Livewire\Component;

class MediaPopUp extends Component
{
    public $model;

    public function render()
    {
        return view('livewire.user.modal.media-pop-up');
    }
}

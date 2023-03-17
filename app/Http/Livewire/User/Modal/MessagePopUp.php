<?php

namespace App\Http\Livewire\User\Modal;

use Livewire\Component;

class MessagePopUp extends Component
{
    public $model;

    public function render()
    {
        return view('livewire.user.modal.message-pop-up');
    }
}

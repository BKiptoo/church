<?php

namespace App\Http\Livewire\User\Modal;

use Livewire\Component;

class TenderFiles extends Component
{
    public $model;
    public function render()
    {
        return view('livewire.user.modal.tender-files');
    }
}

<?php

namespace App\Http\Livewire\User\Modal;

use Livewire\Component;

class JobApplicationPopUp extends Component
{
    public $model;

    public function render()
    {
        return view('livewire.user.modal.job-application-pop-up');
    }
}

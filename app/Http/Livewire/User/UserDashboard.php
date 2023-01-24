<?php

namespace App\Http\Livewire\User;

use LaravelMultipleGuards\Traits\FindGuard;
use Livewire\Component;

class UserDashboard extends Component
{
    use FindGuard;


    public bool $readyToLoad = false;

    public function loadData()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        return view('livewire.user.user-dashboard', [
            'user' => $this->findGuardType()->user()
        ]);
    }
}

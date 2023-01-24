<?php

namespace App\Http\Livewire\User\Inc;

use LaravelMultipleGuards\Traits\FindGuard;
use Livewire\Component;

class SideMenu extends Component
{
    use FindGuard;

    public function logout()
    {
        $this->findGuardType()->logout();
        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.user.inc.side-menu');
    }
}

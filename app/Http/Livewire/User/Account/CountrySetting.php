<?php

namespace App\Http\Livewire\User\Account;

use LaravelMultipleGuards\Traits\FindGuard;
use Livewire\Component;

class CountrySetting extends Component
{
    use FindGuard;

    public $user;
    public $access;

    public function mount()
    {
        $this->user = $this->findGuardType()->user()->load('userCountriesAccess.country');
    }

    public function render()
    {
        return view('livewire.user.account.country-setting');
    }
}

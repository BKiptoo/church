<?php

namespace App\Http\Livewire\User\Account;

use App\Models\Country;
use LaravelMultipleGuards\Traits\FindGuard;
use Livewire\Component;

class CountrySetting extends Component
{
    use FindGuard;

    public $user;
    public $access;

    public function mount()
    {
        $this->user = $this->findGuardType()->user()->load('userCountriesAccess');
        foreach ($this->user->userCountriesAccess as $countriesAccess) {
            $this->access[] = $countriesAccess->country_id;
        }
    }

    public bool $readyToLoad = false;

    public function loadData()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        return view('livewire.user.account.country-setting', [
            'countries' => $this->readyToLoad ? Country::query()->orderBy('name')->get() : []
        ]);
    }
}

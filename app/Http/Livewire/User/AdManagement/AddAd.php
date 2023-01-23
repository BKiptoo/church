<?php

namespace App\Http\Livewire\User\AdManagement;

use App\Models\Country;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LaravelMultipleGuards\Traits\FindGuard;
use Livewire\Component;
use Livewire\WithFileUploads;

class AddAd extends Component
{
    use FindGuard, WithFileUploads, LivewireAlert;

    public $country_id;
    public $name;
    public $linkUrl;
    public $buttonName;
    public $description;

    public bool $readyToLoad = false;

    public function loadData()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        return view('livewire.user.ad-management.add-ad', [
            'countries' => $this->readyToLoad ? Country::query()
                ->orderBy('name')
                ->whereIn('id',
                    $this->findGuardType()->user()
                        ->load('userCountriesAccess')
                        ->userCountriesAccess()->get('country_id')
                        ->toArray()
                )
                ->get() : [],
        ]);
    }
}

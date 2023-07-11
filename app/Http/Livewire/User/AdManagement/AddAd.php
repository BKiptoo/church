<?php

namespace App\Http\Livewire\User\AdManagement;

use App\Http\Controllers\SystemController;
use App\Models\Ad;
use App\Models\Country;
use App\Models\User;
use App\Traits\SharedProcess;
use Exception;
use Illuminate\Validation\ValidationException;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LaravelMultipleGuards\Traits\FindGuard;
use Livewire\Component;
use Livewire\WithFileUploads;
use Note\Note;

class AddAd extends Component
{
    use FindGuard, WithFileUploads, LivewireAlert, SharedProcess;

    public $country_id;
    public $photo;
    public $name;
    public $linkUrl;
    public $buttonName;
    public $description;
    public $validatedData;

    public bool $readyToLoad = false;

    public function loadData()
    {
        $this->readyToLoad = true;
    }

    protected $listeners = [
        'confirmed',
        'cancelled'
    ];

    protected function rules(): array
    {
        return [
            'country_id' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'linkUrl' => ['required', 'string', 'max:255'],
            'buttonName' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'photo' => ['mimes:jpg,jpeg,png,bmp,gif,svg,webp', 'max:15000', 'nullable'] // 5MB Max
        ];
    }

    /**
     * @param $propertyName
     * @throws ValidationException
     */
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function submit()
    {
        $this->validatedData = $this->validate();
        $this->confirm('Are you sure you want to proceed?', [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'confirmButtonText' => 'Yes, I am sure!',
            'cancelButtonText' => 'No, cancel it!',
            'onConfirmed' => 'confirmed',
            'onDismissed' => 'cancelled'
        ]);
    }

    public function confirmed()
    {
        // create the ad here
        $ad = Ad::query()->create($this->validatedData);

        // upload photo
        if ($this->photo)
            SystemController::singleMediaUploadsJob(
                $ad->id,
                Ad::class,
                $this->photo
            );

        Note::createSystemNotification(
            User::class,
            'New Add',
            'Successfully added new ad.'
        );
        $this->alert('success', 'Successfully added new ad.');
        $this->reset();
        $this->loadData();
    }

    public function cancelled()
    {
        $this->alert('error', 'You have canceled.');
    }

    /**
     * @throws Exception
     */
    public function render()
    {
        return view('livewire.user.ad-management.add-ad', [
            'countries' => $this->readyToLoad ? Country::query()
                ->orderBy('name')
                ->whereIn('id',
                    $this->worldAccess()
                )
                ->get() : [],
        ]);
    }
}

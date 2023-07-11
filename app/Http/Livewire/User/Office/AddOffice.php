<?php

namespace App\Http\Livewire\User\Office;

use App\Http\Controllers\SystemController;
use App\Models\Country;
use App\Models\Office;
use App\Models\User;
use App\Traits\SharedProcess;
use Illuminate\Validation\ValidationException;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LaravelMultipleGuards\Traits\FindGuard;
use Livewire\Component;
use Livewire\WithFileUploads;
use Note\Note;

class AddOffice extends Component
{
    use FindGuard, LivewireAlert, SharedProcess, WithFileUploads;

    public $country_id;
    public $name;
    public $description;
    public $photo;
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
            'description' => ['required', 'string'],
            'photo' => ['file', 'image', 'max:15000', 'nullable'] // 5MB Max
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
        // create the faq here
        $office = Office::query()->create($this->validatedData);

        // upload photo
        if ($this->photo)
            SystemController::singleMediaUploadsJob(
                $office->id,
                Office::class,
                $this->photo
            );

        Note::createSystemNotification(
            User::class,
            'New Office',
            'Successfully added new office.'
        );
        $this->alert('success', 'Successfully added new office.');
        $this->reset();
        $this->loadData();
    }

    public function cancelled()
    {
        $this->alert('error', 'You have canceled.');
    }

    public function render()
    {
        return view('livewire.user.office.add-office', [
            'countries' => $this->readyToLoad ? Country::query()
                ->orderBy('name')
                ->whereIn('id',
                    $this->worldAccess()
                )
                ->get() : [],
        ]);
    }
}

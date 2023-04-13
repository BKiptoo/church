<?php

namespace App\Http\Livewire\User\Coverage;

use App\Http\Controllers\SystemController;
use App\Models\Country;
use App\Models\Coverage;
use App\Models\User;
use App\Traits\SharedProcess;
use Exception;
use Illuminate\Validation\ValidationException;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LaravelMultipleGuards\Traits\FindGuard;
use Livewire\Component;
use Livewire\WithFileUploads;
use Note\Note;

class AddCoverage extends Component
{
    use FindGuard, WithFileUploads, LivewireAlert, SharedProcess;

    public $country_id;
    public $mapFile;
    public $name;
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
            'description' => ['required', 'string'],
            'mapFile' => ['file', 'max:10096', 'required'] // 10MB Max
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
        // create the coverage here
        $ad = Coverage::query()->create($this->validatedData);

        // upload file .json
        if ($this->mapFile)
            SystemController::singleMediaUploadsJob(
                $ad->id,
                Coverage::class,
                $this->mapFile,
                true
            );

        Note::createSystemNotification(
            User::class,
            'New Coverage',
            'Successfully added new coverage.'
        );
        $this->alert('success', 'Successfully added new coverage.');
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
        return view('livewire.user.coverage.add-coverage', [
            'countries' => $this->readyToLoad ? Country::query()
                ->orderBy('name')
                ->whereIn('id',
                    $this->worldAccess()
                )
                ->get() : [],
        ]);
    }
}

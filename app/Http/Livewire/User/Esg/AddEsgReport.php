<?php

namespace App\Http\Livewire\User\Esg;

use App\Http\Controllers\SystemController;
use App\Models\Esg;
use App\Models\User;
use App\Traits\SharedProcess;
use Illuminate\Validation\ValidationException;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LaravelMultipleGuards\Traits\FindGuard;
use Livewire\Component;
use Livewire\WithFileUploads;
use Note\Note;

class AddEsgReport extends Component
{
    use FindGuard, WithFileUploads, LivewireAlert, SharedProcess;

    public $report;
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
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'report' => ['file', 'max:15000', 'required'] // 15MB Max
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
        $model = Esg::query()->create($this->validatedData);

        // upload photo
        if ($this->report) {
            SystemController::singleMediaUploadsJob(
                $model->id,
                Esg::class,
                $this->report
            );
        }

        Note::createSystemNotification(
            User::class,
            'New Esg Report',
            'Successfully added new Esg Report.'
        );
        $this->alert('success', 'Successfully added new Esg Report.');
        $this->reset();
        $this->loadData();
    }

    public function cancelled()
    {
        $this->alert('error', 'You have canceled.');
    }

    public function render()
    {
        return view('livewire.user.esg.add-esg-report');
    }
}

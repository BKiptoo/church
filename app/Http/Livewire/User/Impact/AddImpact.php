<?php

namespace App\Http\Livewire\User\Impact;

use App\Http\Controllers\SystemController;
use App\Models\Impact;
use App\Models\ImpactType;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LaravelMultipleGuards\Traits\FindGuard;
use Livewire\Component;
use Livewire\WithFileUploads;
use Note\Note;

class AddImpact extends Component
{
    use FindGuard, LivewireAlert, WithFileUploads;

    public $impact_type_id;
    public $name;
    public $photo;
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
            'impact_type_id' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'photo' => ['file', 'image', 'max:5096', 'nullable'] // 5MB Max
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
        // create here
        $model = Impact::query()->create($this->validatedData);

        // upload photo
        if ($this->photo)
            SystemController::singleMediaUploadsJob(
                $model->id,
                Impact::class,
                $this->photo
            );

        Note::createSystemNotification(
            User::class,
            'New Impact',
            'Successfully added new impact.'
        );
        $this->alert('success', 'Successfully added new impact.');
        $this->reset();
        $this->loadData();
    }

    public function cancelled()
    {
        $this->alert('error', 'You have canceled.');
    }

    public function render()
    {
        return view('livewire.user.impact.add-impact', [
            'impactTypes' => $this->readyToLoad ? ImpactType::query()
                ->orderBy('name')
                ->get() : []
        ]);
    }
}

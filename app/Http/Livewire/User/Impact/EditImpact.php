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

class EditImpact extends Component
{
    use FindGuard, LivewireAlert, WithFileUploads;

    public $model;
    public $impact_type_id;
    public $name;
    public $photo;
    public $description;
    public $validatedData;

    protected $listeners = [
        'confirmed',
        'cancelled'
    ];

    public bool $readyToLoad = false;

    public function loadData()
    {
        $this->readyToLoad = true;
    }

    public function mount(string $slug)
    {
        $this->model = Impact::query()->firstWhere('slug', $slug);
        if (!$this->model) {
            return redirect()->route('list.impacts');
        } else {
            $this->name = $this->model->name;
            $this->impact_type_id = $this->model->impact_type_id;
            $this->description = $this->model->description;
        }
    }

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

    /**
     * update model password here
     */
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
        $this->model->fill($this->validatedData);
        if ($this->model->isClean() && $this->photo === null) {
            $this->alert('warning', 'At least one value must change.');
            return redirect()->back();
        }

        // upload photo
        if ($this->photo)
            SystemController::singleMediaUploadsJob(
                $this->model->id,
                Impact::class,
                $this->photo
            );

        $this->model->save();

        Note::createSystemNotification(
            User::class,
            'Updated Impact',
            'Successfully updated impact.'
        );
        $this->alert('success', 'Successfully updated impact.');
        $this->loadData();
    }

    public function cancelled()
    {
        $this->alert('error', 'You have canceled.');
    }

    public function render()
    {
        return view('livewire.user.impact.edit-impact', [
            'impactTypes' => $this->readyToLoad ? ImpactType::query()
                ->orderBy('name')
                ->get() : []
        ]);
    }
}

<?php

namespace App\Http\Livewire\User\ImpactTypes;

use App\Models\ImpactType;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LaravelMultipleGuards\Traits\FindGuard;
use Livewire\Component;
use Livewire\WithFileUploads;
use Note\Note;

class EditImpactType extends Component
{
    use FindGuard, LivewireAlert, WithFileUploads;

    public $model;
    public $name;
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
        $this->model = ImpactType::query()->firstWhere('slug', $slug);
        if (!$this->model) {
            return redirect()->route('list.impact.types');
        } else {
            $this->name = $this->model->name;
        }
    }

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255']
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
        if ($this->model->isClean()) {
            $this->alert('warning', 'At least one value must change.');
            return redirect()->back();
        }

        Note::createSystemNotification(
            User::class,
            'Updated Impact Type',
            'Successfully updated impact type.'
        );
        $this->alert('success', 'Successfully updated impact type.');
        $this->loadData();
    }

    public function cancelled()
    {
        $this->alert('error', 'You have canceled.');
    }

    public function render()
    {
        return view('livewire.user.impact-types.edit-impact-type');
    }
}

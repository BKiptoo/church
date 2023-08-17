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
use Note\Note;

class EditEsgReport extends Component
{
    use FindGuard, LivewireAlert, SharedProcess;

    public $model;
    public $report;
    public $name;
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
        $this->model = Esg::query()->firstWhere('slug', $slug);
        if (!$this->model) {
            return redirect()->route('list.esg.reports');
        } else {
            $this->name = $this->model->name;
            $this->description = $this->model->description;
        }
    }

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'report' => ['file', 'max:15000', 'nullable'] // 15MB Max
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
        if ($this->model->isClean() && $this->report === null) {
            $this->alert('warning', 'At least one value must change.');
            return redirect()->back();
        }

        // upload photo
        if ($this->report) {
            SystemController::singleMediaUploadsJob(
                $this->model->id,
                Esg::class,
                $this->report
            );
        }

        $this->model->save();

        Note::createSystemNotification(
            User::class,
            'Updated Esg Report',
            'Successfully updated Esg report.'
        );
        $this->alert('success', 'Successfully updated Esg report.');
        $this->loadData();
    }

    public function cancelled()
    {
        $this->alert('error', 'You have canceled.');
    }

    public function render()
    {
        return view('livewire.user.esg.edit-esg-report');
    }
}

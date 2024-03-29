<?php

namespace App\Http\Livewire\User\Events;

use App\Http\Controllers\SystemController;
use App\Models\Ad;
use App\Models\Country;
use App\Models\Event;
use App\Models\User;
use App\Traits\SharedProcess;
use Illuminate\Validation\ValidationException;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LaravelMultipleGuards\Traits\FindGuard;
use Livewire\Component;
use Livewire\WithFileUploads;
use Note\Note;

class EditEvent extends Component
{
    use FindGuard, LivewireAlert, SharedProcess, WithFileUploads;

    public $model;
    public $country_id;
    public $photo;
    public $name;
    public $startDate;
    public $endDate;
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
        $this->model = Ad::query()->firstWhere('slug', $slug);
        if (!$this->model) {
            return redirect()->route('list.ads');
        } else {
            $this->name = $this->model->name;
            $this->country_id = $this->model->country_id;
            $this->startDate = $this->model->startDate;
            $this->endDate = $this->model->endDate;
            $this->description = $this->model->description;
        }
    }

    protected function rules(): array
    {
        return [
            'country_id' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'startDate' => ['date', 'required', 'after:today'],
            'endDate' => ['date', 'required', 'after:startDate'],
            'description' => ['required', 'string'],
            'photo' => ['image', 'max:15000', 'nullable'] // 5MB Max
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
                Event::class,
                $this->photo
            );

        $this->model->save();

        Note::createSystemNotification(
            User::class,
            'Updated Event',
            'Successfully updated event.'
        );
        $this->alert('success', 'Successfully updated event.');
        $this->loadData();
    }

    public function cancelled()
    {
        $this->alert('error', 'You have canceled.');
    }

    public function render()
    {
        return view('livewire.user.events.edit-event', [
            'countries' => $this->readyToLoad ? Country::query()
                ->orderBy('name')
                ->whereIn('id',
                    $this->worldAccess()
                )
                ->get() : [],
        ]);
    }
}

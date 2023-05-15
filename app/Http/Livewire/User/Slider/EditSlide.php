<?php

namespace App\Http\Livewire\User\Slider;

use App\Http\Controllers\SystemController;
use App\Models\Country;
use App\Models\Slide;
use App\Models\User;
use App\Traits\SharedProcess;
use Illuminate\Validation\ValidationException;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LaravelMultipleGuards\Traits\FindGuard;
use Livewire\Component;
use Livewire\WithFileUploads;
use Note\Note;

class EditSlide extends Component
{
    use FindGuard, LivewireAlert, SharedProcess, WithFileUploads;

    public $model;
    public $country_id;
    public $photo;
    public $buttonName;
    public $buttonUrl;
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

    public function mount(string $id)
    {
        $this->model = Slide::query()->findOrFail($id);
        if (!$this->model) {
            return redirect()->route('list.slides');
        } else {
            $this->country_id = $this->model->country_id;
            $this->buttonUrl = $this->model->buttonUrl;
            $this->buttonName = $this->model->buttonName;
            $this->description = $this->model->description;
        }
    }

    protected function rules(): array
    {
        return [
            'country_id' => ['required', 'string', 'max:255'],
            'buttonUrl' => ['required', 'string', 'max:255'],
            'buttonName' => ['required', 'string', 'max:255'],
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
                Slide::class,
                $this->photo
            );

        $this->model->save();

        Note::createSystemNotification(
            User::class,
            'Updated Slide',
            'Successfully updated slide.'
        );
        $this->alert('success', 'Successfully updated slide.');
        $this->loadData();
    }

    public function cancelled()
    {
        $this->alert('error', 'You have canceled.');
    }

    public function render()
    {
        return view('livewire.user.slider.edit-slide', [
            'countries' => $this->readyToLoad ? Country::query()
                ->orderBy('name')
                ->whereIn('id',
                    $this->worldAccess()
                )
                ->get() : []
        ]);
    }
}

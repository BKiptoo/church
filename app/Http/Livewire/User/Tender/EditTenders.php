<?php

namespace App\Http\Livewire\User\Tender;

use App\Http\Controllers\SystemController;
use App\Models\Country;
use App\Models\Tender;
use App\Models\User;
use App\Traits\SharedProcess;
use Illuminate\Validation\ValidationException;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LaravelMultipleGuards\Traits\FindGuard;
use Livewire\Component;
use Livewire\WithFileUploads;
use Note\Note;

class EditTenders extends Component
{
    use FindGuard, LivewireAlert, SharedProcess, WithFileUploads;

    public $model;
    public $country_id;
    public $tenderFiles = [];
    public $name;
    public $description;
    public $closingDate;
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
        $this->model = Tender::query()->firstWhere('slug', $slug);
        if (!$this->model) {
            return redirect()->route('list.tenders');
        } else {
            $this->name = $this->model->name;
            $this->country_id = $this->model->country_id;
            $this->closingDate = $this->model->closingDate;
            $this->description = $this->model->description;
        }
    }

    protected function rules(): array
    {
        return [
            'country_id' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'closingDate' => ['date', 'required', 'after:today'],
            'description' => ['required', 'string'],
            'tenderFiles.*' => ['file', 'max:100096', 'nullable'] // 100MB Max
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
        if ($this->model->isClean() && count($this->tenderFiles)) {
            $this->alert('warning', 'At least one value must change.');
            return redirect()->back();
        }

        // upload photo
        if (count($this->tenderFiles))
            SystemController::multipleMediaUploadsJob(
                $this->model->id,
                Tender::class,
                $this->tenderFiles
            );

        $this->model->save();

        Note::createSystemNotification(
            User::class,
            'Updated Tender',
            'Successfully updated tender.'
        );
        $this->alert('success', 'Successfully updated tender.');
        $this->loadData();
    }

    public function cancelled()
    {
        $this->alert('error', 'You have canceled.');
    }

    public function render()
    {
        return view('livewire.user.tender.edit-tenders', [
            'countries' => $this->readyToLoad ? Country::query()
                ->orderBy('name')
                ->whereIn('id',
                    $this->worldAccess()
                )
                ->get() : []
        ]);
    }
}

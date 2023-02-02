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

class AddTenders extends Component
{
    use FindGuard, LivewireAlert, SharedProcess, WithFileUploads;

    public $country_id;
    public $tenderFiles;
    public $name;
    public $description;
    public $closingDate;
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
        // create the event here
        $event = Tender::query()->create($this->validatedData);

        // upload photo
        if (count($this->tenderFiles))
            SystemController::multipleMediaUploadsJob(
                $event->id,
                Tender::class,
                $this->tenderFiles
            );

        Note::createSystemNotification(
            User::class,
            'New Tender',
            'Successfully added tender.'
        );
        $this->alert('success', 'Successfully added tender.');
        $this->reset();
        $this->loadData();
    }

    public function cancelled()
    {
        $this->alert('error', 'You have canceled.');
    }

    public function render()
    {
        return view('livewire.user.tender.add-tenders',[
            'countries' => $this->readyToLoad ? Country::query()
                ->orderBy('name')
                ->whereIn('id',
                    $this->worldAccess()
                )
                ->get() : []
        ]);
    }
}

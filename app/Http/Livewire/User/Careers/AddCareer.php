<?php

namespace App\Http\Livewire\User\Careers;

use App\Models\Career;
use App\Models\Country;
use App\Models\User;
use App\Traits\SharedProcess;
use Exception;
use Illuminate\Validation\ValidationException;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LaravelMultipleGuards\Traits\FindGuard;
use Livewire\Component;
use Note\Note;

class AddCareer extends Component
{
    use FindGuard, LivewireAlert, SharedProcess;

    public $country_id;
    public $name;
    public $description;
    public $deadLine;
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

    protected function rules(): array
    {
        return [
            'country_id' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'deadLine' => ['date', 'required', 'after:today'],
            'description' => ['required', 'string']
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
        Career::query()->create($this->validatedData);
        Note::createSystemNotification(
            User::class,
            'New Add',
            'Successfully added new career.'
        );
        $this->alert('success', 'Successfully added new career.');
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
        return view('livewire.user.careers.add-career', [
            'countries' => $this->readyToLoad ? Country::query()
                ->orderBy('name')
                ->whereIn('id',
                    $this->worldAccess()
                )
                ->get() : [],
        ]);
    }
}

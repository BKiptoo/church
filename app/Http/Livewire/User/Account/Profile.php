<?php

namespace App\Http\Livewire\User\Account;

use App\Models\User;
use Illuminate\Validation\ValidationException;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LaravelMultipleGuards\Traits\FindGuard;
use Livewire\Component;
use Note\Note;

class Profile extends Component
{
    use FindGuard, LivewireAlert;

    public $user;
    public $name;
    public $phoneNumber;
    public $email;
    public $photo;
    public $position;
    public $validatedData;

    protected $listeners = [
        'confirmed',
        'cancelled'
    ];

    public function mount()
    {
        $this->user = $this->findGuardType()->user()->load('media', 'country');
        $this->name = $this->user->name;
        $this->phoneNumber = $this->user->phoneNumber;
        $this->email = $this->user->email;
        $this->position = $this->user->position;
    }

    protected array $rules = [
        'name' => ['required', 'string', 'max:255'],
        'position' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255'],
        'phoneNumber' => ['required', 'string']
    ];

    protected array $messages = [
        'email.email' => 'The email address format is not valid.',
    ];

    /**
     * D0 real time validations
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
        $this->user->fill($this->validatedData);
        if ($this->user->isClean()) {
            $this->alert('warning', 'At least one value must change.');
            return redirect()->back();
        }

        $this->user->save();
        Note::createSystemNotification(
            User::class,
            'Profile Update',
            'Successfully updated your profile.'
        );
        $this->alert('success', 'Successfully updated your profile.');
    }

    public function uploadAvatar()
    {

    }

    public function cancelled()
    {
        $this->alert('error', 'You have canceled.');
    }

    public function render()
    {
        return view('livewire.user.account.profile');
    }
}

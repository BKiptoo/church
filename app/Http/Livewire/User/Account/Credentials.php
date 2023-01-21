<?php

namespace App\Http\Livewire\User\Account;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LaravelMultipleGuards\Traits\FindGuard;
use Livewire\Component;
use Exception;
use Note\Note;

class Credentials extends Component
{
    use FindGuard, LivewireAlert;

    public $user;
    public $password_confirmation;
    public $password;

    protected $listeners = [
        'confirmed',
        'cancelled'
    ];

    public function mount()
    {
        try {
            $this->user = $this->findGuardType()->user();
        } catch (Exception $e) {
            $this->alert('error', 'Try again an error occurred.');
        }
    }

    protected function rules(): array
    {
        return [
            'password' => ['required', 'confirmed', 'same:password_confirmation', Password::min(8)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            ]
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
     * update user password here
     */
    public function submit()
    {
        $this->validate();
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
        // Check if current password is same as the new one
        if (Hash::check($this->password, $this->user->getAuthPassword())) {
            $this->reset(['password', 'password_confirmation']);
            $this->alert('warning', 'Sorry new password is the same as the current one.');
            return redirect()->back();
        }

        $this->user->update([
            'password' => bcrypt($this->password)
        ]);

        Note::createSystemNotification(
            User::class,
            'Password Update',
            'Credentials updated successfully.'
        );
        $this->emit('noteAdded');
        $this->reset(['password', 'password_confirmation']);
        $this->alert('success', 'Credentials updated successfully.');
    }

    public function cancelled()
    {
        $this->alert('error', 'You have canceled.');
    }

    public function render()
    {
        return view('livewire.user.account.credentials');
    }
}

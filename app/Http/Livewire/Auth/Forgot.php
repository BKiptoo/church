<?php

namespace App\Http\Livewire\Auth;

use App\Jobs\MailJob;
use App\Models\User;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\ValidationException;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Forgot extends Component
{
    use LivewireAlert;

    public $email;

    protected array $rules = [
        'email' => ['required', 'string', 'email', 'exists:users']
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

    /**
     * reset user password here
     */
    public function resetPassword()
    {
        $this->validate();

        // fetch the user here
        $user = User::query()->firstWhere('email', $this->email);

        // send email here
        dispatch(new MailJob(
            $user->name,
            $user->email,
            'Account Password Reset',
            'You are receiving this email because we received a password reset request for your account.
             This password reset link will expire in 60 minutes.
             If you did not request a password reset, no further action is required.',
            true,
            URL::temporarySignedRoute('reset', now()->addMinutes(60), ['token' => encrypt($this->email, true)]),
            '<<< RESET PASSWORD >>>'
        ))->onQueue('emails')->delay(2);

        $this->reset(['email']);
        $this->alert(
            'success',
            'A new password reset link has been sent to your email address.
             Kindly check and use it to update your password.'
        );
    }

    public function render()
    {
        return view('livewire.auth.forgot')->layout('layouts.auth');
    }
}

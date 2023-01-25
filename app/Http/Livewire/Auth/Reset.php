<?php

namespace App\Http\Livewire\Auth;

use App\Models\User;
use App\Traits\TriggerOtp;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LaravelMultipleGuards\Traits\FindGuard;
use Livewire\Component;

class Reset extends Component
{
    use LivewireAlert, FindGuard, TriggerOtp;

    public $email;
    public $password;
    public $password_confirmation;

    public function mount(string $token)
    {
        if (!request()->hasValidSignature()) {
            session()->flash('error', 'Kindly generate a new password reset link.');
            return redirect()->route('forgot');
        }

        $this->email = decrypt($token, true);
    }

    protected function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email', 'exists:users', 'max:255'],
            'password' => ['required', 'confirmed', 'same:password_confirmation', Password::min(8)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            ],
        ];
    }

    /**
     * D0 real time validations
     * @param $propertyName
     * @throws ValidationException
     */
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function resetPassword()
    {
        $this->validate();

        $user = User::query()->firstWhere('email', $this->email);
        if (Hash::check($this->password, $user->password)) {
            $this->alert('warning', 'New password cannot be the same as your current password.');
            return redirect()->back();
        }

        $user->update([
            'password' => bcrypt($this->password)
        ]);

        // authenticate users here
        auth()->login($user);

        // Send opt for account verification...
//        $this->sendOtp($this->findGuardType()->user());
        $this->findGuardType()->user()->update([
            'isOtpVerified' => true
        ]);

        $this->alert('success', 'Account password has been updated.');
        return redirect()->intended();
    }

    public function render()
    {
        return view('livewire.auth.reset')->layout('layouts.auth');
    }
}

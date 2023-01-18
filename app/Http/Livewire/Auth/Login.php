<?php

namespace App\Http\Livewire\Auth;

use App\Traits\TriggerOtp;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Login extends Component
{
    use LivewireAlert, TriggerOtp;

    public $email;
    public $password;
    public $remember;

    public function mount()
    {
        // check if user is already authorized
        if (Auth::check())
            return redirect()->route('home');
    }

    protected array $rules = [
        'email' => ['required', 'string', 'exists:users'],
        'password' => ['required', 'string'],
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
     * login the user here
     * @return RedirectResponse
     */
    public function loginUser()
    {
        $this->validate();

        if (Auth::attempt([
            'email' => $this->email,
            'password' => $this->password,
            'is_active' => true
        ], $this->remember
        )) {
            // Send opt for account verification...
            $this->sendOtp($this->findGuardType()->user());

            // Authentication passed...
            return redirect()->intended();
        }

        $this->reset(['password']);
        $this->alert('error', 'The credentials given don\'t match our records.');
    }

    public function render()
    {
        return view('livewire.auth.login')->layout('layouts.auth');
    }
}

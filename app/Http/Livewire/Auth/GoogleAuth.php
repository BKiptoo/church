<?php

namespace App\Http\Livewire\Auth;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Laravel\Socialite\Facades\Socialite;
use Livewire\Component;

class GoogleAuth extends Component
{
    use LivewireAlert;

    public function mount()
    {
        try {
            /**
             * first fetch user from provider
             * using the code
             */
            $socialite = Socialite::driver('google')->user();

            $existingUser = User::query()->firstWhere('email', $socialite->email);
            if (!$existingUser) {
                $this->alert('info', 'Kindly reach the admin to have an account created for you.');
                return redirect()->route('login');
            }

            // login user here
            auth()->login($existingUser);
            if (!auth()->user()->isActive) {
                $this->alert('warning', 'Your account has been disabled.');
                return redirect()->route('login');
            }

            return redirect()->to('home/');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $this->alert('error', 'An error occurred.');
        }
    }

    public function render()
    {
        return view('livewire.auth.google-auth');
    }
}

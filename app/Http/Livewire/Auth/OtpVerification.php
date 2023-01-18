<?php

namespace App\Http\Livewire\Auth;

use App\Models\Otp;
use App\Traits\TriggerOtp;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use LaravelMultipleGuards\Traits\FindGuard;
use Livewire\Component;

class OtpVerification extends Component
{
    use FindGuard, LivewireAlert, TriggerOtp;

    public $otp;

    protected $listeners = [
        'confirmed',
        'cancelled'
    ];

    protected function rules(): array
    {
        return [
            'otp' => ['required', 'integer', 'min:10000', 'max:31000',
                Rule::exists((new Otp())->getTable())->where(function ($query) {
                    return $query->latest()
                        ->where('user_id', $this->findGuardType()->id())
                        ->whereBetween('created_at', [now()->subMinutes(5), now()])
                        ->where('isUsed', false);
                }),
            ],
        ];
    }

    protected array $messages = [
        'otp.min' => 'Wrong sms otp provided.',
        'otp.max' => 'Wrong sms otp provided.',
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
        $this->validate();

        // verify the otp code
        $this->findGuardType()
            ->user()
            ->otps()
            ->where('isUsed', false)
            ->where('otp', $this->otp)
            ->first()
            ->update([
                'isUsed' => true
            ]);

        // update the account opt status
        $this->findGuardType()->user()->update([
            'isOtpVerified' => true
        ]);

        return redirect()->route('home');
    }

    public function resend()
    {
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
        $minutes = 5;

        $model = $this->findGuardType()
            ->user()
            ->otps()
            ->first();

        if ($model)
            // check if the current OTP is more than
            $minutes = Carbon::parse(now())->diffInMinutes($model->created_at);

        if ($minutes <= 5) {
            $this->alert(
                'info',
                'You have an active otp sms.',
                [
                    'position' => 'center',
                    'timer' => 5000,
                    'toast' => false,
                    'timerProgressBar' => true,
                ]);
        } else {
            $this->sendOtp($this->findGuardType()->user());

            $this->alert(
                'success',
                'Otp has been sent to ' . $this->findGuardType()->user()->phoneNumber . '
                 .Active for the next ' . $minutes . ' minutes.',
                [
                    'position' => 'center',
                    'timer' => 5000,
                    'toast' => false,
                    'timerProgressBar' => true,
                ]);
        }
    }

    public function cancelled()
    {
        $this->alert('error', 'You have canceled.');
    }

    public function render()
    {
        return view('livewire.auth.otp-verification')->layout('layouts.auth');
    }
}

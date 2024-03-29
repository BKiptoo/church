<?php

namespace App\Traits;

use App\Http\Controllers\SystemController;
use App\Jobs\SendSmsJob;
use App\Models\Otp;

trait TriggerOtp
{
    /**
     * send otp here to the user
     * for account validation and other additional
     * functions
     * @param object $user
     * @param string|null $otp
     * @param string|null $message
     * @return int
     */
    protected function sendOtp(object $user, string|null $otp = null, string|null $message = null): int
    {
        if ($otp === null)
            $otp = rand(10000, 31000);

        // mark all previous otp's as used
        if (count($user->otps))
            $user->otps()
                ->where('isUsed', false)
                ->update([
                    'isUsed' => true
                ]);

        // Create the otp here
        Otp::query()->create([
            'user_id' => $user->id,
            'otp' => $otp,
            'isUsed' => $message !== null
        ]);

        // update the account opt status
        $user->update([
            'isOtpVerified' => false
        ]);

        // Sen opt for account verification...
        dispatch(new SendSmsJob(
            [SystemController::formatPhoneNumber(
                $user->phoneNumber,
                $user->country->data['short2Code']
            )],// convert the phoneNumber to the country base
            $message !== null ? $message : 'Your OTP is ' . $otp
        ))->onQueue('sms')->delay(1);

        return $otp;
    }
}

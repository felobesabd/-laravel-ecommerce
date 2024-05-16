<?php

namespace App\Http\Services;

use App\Models\User;
use App\Models\VerificationCode;
use Illuminate\Support\Facades\Auth;

class VerificationService
{
    /** set OTP code for mobile
     * @param $data
     *
     * @return VerificationCode
     */
    public function setVerificationCode($data)
    {
        $code = mt_rand(100000, 999999);
        $data['code'] = $code;

        VerificationCode::whereNotNull('user_id')->where(['user_id' => $data['user_id']])->delete();

        return VerificationCode::create($data);
    }

    public function checkCode($code)
    {
        if (Auth::guard('web')->check()) {
            $loggedUserId = Auth::id();
            $verification = VerificationCode::where('user_id', $loggedUserId)->first();

            if ($verification->code == $code) {
                User::where('id', $loggedUserId)->update(['mobile_verified_at' => now()]);
                return true;
            } else {
                return  false;
            }
        }
        return false;
    }

    public function removeCode($code)
    {
        VerificationCode::where('code', $code)->delete();
    }
}

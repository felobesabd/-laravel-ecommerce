<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\VerificationCodeRequest;
use App\Http\Services\VerificationService;

class VerificationCodeController extends Controller
{
    private $verificationService;

    public function __construct(VerificationService $verificationService)
    {
        $this->verificationService = $verificationService;
    }

    public function verify(VerificationCodeRequest $request) {
        $verified = $this->verificationService->checkCode($request->code);

        if (!$verified) {
            return redirect()->route('verification.form')->withErrors(['code' => 'invalid code']);
        } else {
            $this->verificationService->removeCode($request->code);
            return redirect()->route('home');
        }
    }

    public function verification() {
        return view('auth.verification');
    }
}

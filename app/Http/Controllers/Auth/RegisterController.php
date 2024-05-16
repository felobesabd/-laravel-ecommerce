<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Services\VerificationService;
use App\Providers\RouteServiceProvider;
use \App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DB;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    private $verificationCode;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @param VerificationService $verificationCode
     */
    public function __construct(VerificationService $verificationCode)
    {
        $this->middleware('guest');
        $this->verificationCode = $verificationCode;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function create(array $data)
    {
        try {
            DB::beginTransaction();
            $verification = [];

            $user = User::create([
                'name' => $data['name'],
                'mobile' => $data['mobile'],
                'password' => Hash::make($data['password']),
            ]);

            // send user_id to setVerificationCode
            $verification['user_id'] = $user->id;
            $this->verificationCode->setVerificationCode($verification);

            DB::commit();

//            return redirect()->route('verify')->with(['user' => $user]);
            return $user;
        } catch (\Exception $exception) {
            DB::rollback();
        }
    }
}

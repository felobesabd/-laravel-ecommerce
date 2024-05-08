<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login()
    {
        return view('dashboard.auth.login');
    }

    public function storeLogin(LoginRequest $request)
    {
        // validation

        // check email - password
        $remember_me = $request->has('remember_me') ? true : false;
        $credentials = auth()->guard('admin')->attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            ],
            $remember_me
        );

        if ($credentials) {
            return redirect()->route('admin.index');
        }

        return redirect()->back()->with(['error' => 'please login again..']);
    }

    public function logout()
    {
        $guard = $this->getGuard();
        $guard->logout();

        return redirect()->route('admin.login');
    }

    private function getGuard()
    {
        return auth('admin');
    }
}

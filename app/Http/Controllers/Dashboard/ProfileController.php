<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Models\Admin;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function getAdmin()
    {
        $admin_id = auth('admin')->user()->id;
        return Admin::find($admin_id);
    }

    public function editProfile()
    {
        $admin = $this->getAdmin();

        return view('dashboard.profile.edit', compact('admin'));
    }

    public function updateProfile(ProfileRequest $request)
    {
        //validate
        // db
        try {
            $admin = $this->getAdmin();

            if ($request->filled('password')) {
                $request->merge(['password' => bcrypt($request->password)]);
            }

            unset($request['id']);
            unset($request['password_confirmation']);

            $admin->update($request->all());

            return redirect()->back()->with(['success' => 'Update successfully']);
        } catch (\Exception $ex) {
            return redirect()->back()->with(['error' => 'Update failed']);
        }

    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\UserAddressResource;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    public function userInfoUpdate(Request $request)
    {
        $user = auth()->user();
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'dob' => $request->dob,
            'phone' => $request->phone,
            'job_title' => $request->job_title,
            'gender' => $request->gender,
        ]);

        return new UserResource($user);
    }

    public function userAddressUpdate(Request $request)
    {
        $userAddress = auth()->user()->userAddress()->updateOrCreate([
            'user_id' => auth()->id()
        ], [
            'region_id' => $request->region_id,
            'district_id' => $request->district_id,
            'township_id' => $request->township_id,
            'address' => $request->address,
            'zip_code' => $request->zip_code,
        ]);

        return new UserAddressResource($userAddress);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed|min:8|max:20'
        ]);

        $user = auth()->user();

        if (!Hash::check($request->old_password, $user->password)) {
            throw ValidationException::withMessages([
                'old_password' => 'Your current password doesn\'t match.!'
            ]);
        }

        $user->update([
            'password' => $request->password
        ]);

        return new UserResource($user);
    }
}

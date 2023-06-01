<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register()
    {
        request()->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'phone' => 'required|string|unique:users,phone',
            'password' => 'required|confirmed|min:8|max:20'
        ]);

        try {

            DB::beginTransaction();

            $user = User::create([
                'name' => request()->name,
                'email' => request()->email,
                'phone' => request()->phone,
                'password' => request()->password,
            ]);

            if ($user) {
                $user->last_login_at = now();
                // $user->ip_address = request()->ip();
                $user->save();
            }

            $token = $user->createToken('API_TOKEN')->plainTextToken;

            $response = [
                'user' => $user,
                'token' => $token
            ];

            DB::commit();

            return response($response, 201);
            // return response()
            //     ->json([
            //         "status" => "success",
            //         "data" => $user
            //     ], 200)
            //     ->header("Authorization", $token);

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => $e->getMessage()
            ], 401);
        }
    }

    public function login()
    {
        $attributes = request()->validate([
            'email' => 'required|string|email',
            'password' => 'required'
        ]);

        // Get user
        $user = User::where('email', request()->email)->first();

        // Check email & password
        // if (Auth::attempt($attributes)) {
        if (!$user || !Hash::check(request()->password, $user->password)) {
            // return response([
            //     'message' => 'The provided credentials are incorrect'
            // ], 401);
            throw ValidationException::withMessages([
                'message' => ['The provided credentials are incorrect.'],
            ]);
        }

        // $device = request()->userAgent();
        $expiresAt = request()->remember ? null : now()->addMinutes(config('session.lifetime'));

        $user->update([
            'last_login_at' => now()
        ]);

        $token = $user->createToken('API_TOKEN')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        // return response()->json([
        //     'access_token' => $user->createToken($device, expiresAt: $expiresAt)->plainTextToken,
        // ], Response::HTTP_CREATED);

        return response($response, 201);
    }

    public function logout()
    {
        request()->user()->currentAccessToken()->delete();

        // auth()->user()->tokens()->delete();

        return response()
            ->json([
                "status" => "success"
            ], 200);

        // return response()->noContent();

    }
}

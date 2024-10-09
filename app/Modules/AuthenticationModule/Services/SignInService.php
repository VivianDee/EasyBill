<?php

namespace App\Modules\AuthenticationModule\Services;

use App\Enums\TokenAbility;
use App\Helpers\ResponseHelper;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class SignInService
{

    // Login
    public function login(Request $request)
    {
        try {
            // Validate the incoming request data
            $validator = Validator::make($request->all(), [
                "email" => "required|email",
                "password" => "required|string|min:8",
            ]);

            // If validation fails, return an error response
            if ($validator->fails()) {
                return ResponseHelper::error(
                    message: "Validation failed",
                    error: $validator->errors()->toArray()
                );
            }

            // Find the user by email
            $user = User::where("email", $request->email)->first();


            // Check if the user exists and if the password matches
            if (!$user || !Hash::check($request->password, $user->password)) {
                return ResponseHelper::error(
                    message: "Invalid email or password"
                );
            }


            // Create and return token
            $token = $user->createToken("access-token", [TokenAbility::ACCESS_API->value])->plainTextToken;

            return ResponseHelper::success(
                data: [
                    "access_token" => $token,
                    "user" => new UserResource($user)
                ],
                message: "Login successful"
            );
        } catch (\Throwable $th) {
            return ResponseHelper::internalServerError(
                message: "Internal Server Error",
                error: $th->getMessage()
            );
        }
    }


    // Logout
    public function logout(Request $request)
    {
        try {
            // Get the current authenticated user
            $user = $request->user();

            if (!$user) {
                return ResponseHelper::unauthorized(
                    message: "User not authenticated"
                );
            }

            // Revoke the token used in the current request
            $request->user()->currentAccessToken()->delete();

            return ResponseHelper::success(
                message: "Logout successful"
            );
        } catch (\Throwable $th) {
            return ResponseHelper::internalServerError(
                message: "Internal Server Error",
                error: $th->getMessage()
            );
        }
    }
}

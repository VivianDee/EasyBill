<?php

namespace App\Modules\AuthenticationModule\Services;

use App\Helpers\ResponseHelper;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ChangePasswordService
{
    public function changePassword(Request $request)
    {
        try {
             // Validate the incoming request data
            $validator = Validator::make($request->all(), [
                "email" => "required|email",
                "old_password" => "required|string",
                "new_password" => "required|string|min:8",
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


            // Check if the user exists and if the old password matches
            if (!$user || !Hash::check($request->old_password, $user->password)) {
                return ResponseHelper::error(
                    message: "Invalid email or old password"
                );
            }

            // Update the user's password
            $user->password = Hash::make($request->new_password);
            $user->save();

            return ResponseHelper::success(message: "Password changed successfully");
        } catch (\Throwable $th) {
            return ResponseHelper::internalServerError(
                message: "Internal Server Error",
                error: $th->getMessage()
            );
        }
    }
}

<?php

namespace App\Modules\AuthenticationModule\Services;

use App\Helpers\ResponseHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\PasswordRecoveryToken;
use App\Models\PasswordResetToken;
use App\Modules\MailModule\MailModule;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Exception;

class AccountRecoveryService
{
    public function sendOtp(Request $request)
    {
        try {
            // Validate the incoming request data
            $validator = Validator::make($request->all(), [
                "email" => "required|email",
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

            // Check if the user exists
            if (!$user) {
                return ResponseHelper::notFound(
                    message: "No User Found"
                );
            }

            // Generate a random 6-character alphanumeric token
            $token = Str::random(6);


            // Create or update the token in the database
            $passwordResetToken = PasswordResetToken::updateOrCreate(
                ['email' => $request->email],
                [
                    'token' => $token,
                    'created_at' => Carbon::now(),
                ]
            );

            // Send Welcome email
            $mailRequest = new Request([
                "email" => $user->email,
                "first_name" => $user->first_name,
                "otp" => $token,
                "otp_expiry" => 5,
            ]);

            MailModule::sendAccountRecoveryMail($mailRequest);

            return ResponseHelper::success(message: "Password recovery initiated. Check your email for further instructions.");
        } catch (\Throwable $th) {
            return ResponseHelper::internalServerError(
                message: "Internal Server Error",
                error: $th->getMessage()
            );
        }
    }

    public function changePassword(Request $request)
    {
        try {
            // Validate the incoming request data
            $validator = Validator::make($request->all(), [
                "email" => "required|email",
                "otp" => "required|string",
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

            // Check if the user exists
            if (!$user) {
                return ResponseHelper::notFound(
                    message: "No User Found"
                );
            }


            $passwordRecoveryToken = PasswordResetToken::where("email", $user->email)
                ->where("token", $request->otp)
                ->first();

            // Check if the token does not exist or if it was created more than 5 minutes ago
            if (!$passwordRecoveryToken || $passwordRecoveryToken->created_at < now()->subMinutes(5)) {
                return ResponseHelper::error(message: "Invalid or expired otp.");
            }

            $user->password = Hash::make($request->new_password);
            $user->save();

            $passwordRecoveryToken->delete();

            return ResponseHelper::error(message: "Password updated successfully");
        } catch (\Throwable $th) {
            return ResponseHelper::internalServerError(
                message: "Internal Server Error",
                error: $th->getMessage()
            );
        }
    }
}

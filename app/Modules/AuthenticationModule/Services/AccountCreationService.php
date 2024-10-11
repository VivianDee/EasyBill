<?php 

namespace App\Modules\AuthenticationModule\Services;

use App\Enums\AccountType;
use App\Helpers\ResponseHelper;
use Illuminate\Http\Request;
use App\Models\User;
use App\Modules\MailModule\MailModule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountCreationService
{
    public function register(Request $request)
    {
        try {

             // Validate the incoming request data
            $validator = Validator::make($request->all(), [
                "first_name" => "required|string|max:255",
                "last_name" => "required|string|max:255",
                'email' => 'required|email:rfc,dns|max:255|unique:users,email',
                "password" => "required|string|min:8",
            ]);

            // If validation fails, return an error response
            if ($validator->fails()) {
                return ResponseHelper::error(
                    message: "Validation failed",
                    error: $validator->errors()->toArray()
                );
            }

            // Hash Password
            $hashedPassword = Hash::make($request->password);

            // Create user
            $user = User::create([
                "name" => $request->first_name . " " . $request->last_name,
                "first_name" => $request->first_name,
                "last_name" => $request->last_name,
                "email" => $request->email,
                "password" => $hashedPassword,
                "ip_address" => $request->ip(),
                "account_type" => AccountType::AnonymousSignUp->value,
            ]);


            if (!$user) {
                return ResponseHelper::error(
                    message: "User registration failed"
                );
            }

            // // Send Welcome email
            // $mailRequest = new Request([
            //     "email" => $user->email,
            //     "first_name" => $user->first_name,
            // ]);

            // MailModule::sendWelcomeMail($mailRequest);

            return ResponseHelper::created(
                message: "User resgistered successfully"
            );
        } catch (\Throwable $th) {
            return ResponseHelper::internalServerError(
                message: "Internal Server Error",
                error: $th->getMessage() . " on line: " . $th->getLine() . "file:" . $th->getFile()
            );
        }
    }
}
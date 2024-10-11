<?php

namespace App\Modules\UserModule\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ResponseHelper;
use App\Http\Resources\UserResource;

class UserUpdateService
{
    public function updateUser(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                "first_name" => "nullable|string|max:255",
                "last_name" => "nullable|string|max:255",
                'email' => 'nullable|email:rfc,dns|max:255|unique:users,email',
            ]);

            // If validation fails, return an error response
            if ($validator->fails()) {
                return ResponseHelper::error(
                    message: "Validation failed",
                    error: $validator->errors()->toArray()
                );
            }

            $user = $request->user();


            if (!$user) {
                return ResponseHelper::notFound(
                    message: "User not found"
                );
            }

            $user->update($request->only(['first_name', 'last_name', 'email']));


            return ResponseHelper::success(
                message: "User updated successfully",
                data: new UserResource($user)
            );
        } catch (\Throwable $th) {
            return ResponseHelper::internalServerError(
                message: "Internal Server Error",
                error: $th->getMessage()
            );
        }
    }
}

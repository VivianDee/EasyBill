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
            $user_id = $request->route('id');

            $user = User::findOrFail($user_id);


            if (!$user) {
                return ResponseHelper::notFound(
                    message: "User not found"
                );
            }

            $validator = Validator::make($request->all(), [
                "first_name" => "required|string|max:255",
                "last_name" => "required|string|max:255",
                'email' => 'required|email:rfc,dns|max:255|unique:users,email',
            ]);

            // If validation fails, return an error response
            if ($validator->fails()) {
                return ResponseHelper::error(
                    message: "Validation failed",
                    error: $validator->errors()->toArray()
                );
            }

            $user->update(array_filter($request->only(['first_name', 'last_name', 'email'])));


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

<?php

namespace App\Modules\UserModule\Services;

use App\Helpers\ResponseHelper;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserRetrievalService
{
    public function getUser(Request $request)
    {
        try {
            $user_id = $request->route('id');

            $user = $user_id ? User::find($user_id) : $request->user();


            if (!$user) {
                return ResponseHelper::notFound(
                    message: "User not found"
                );
            }


            return ResponseHelper::success(
                message: "User details retrieved successfully",
                data: new UserResource($user)
            );
        } catch (\Throwable $th) {
            return ResponseHelper::internalServerError(
                message: "Internal Server Error",
                error: $th->getMessage()
            );
        }
    }

    public function getAllUsers()
    {
        try {

            $users = User::all();

            if (empty($users)) {
                return ResponseHelper::notFound(
                    message: "No Users found"
                );
            }

            return ResponseHelper::success(
                message: "Users retrieved successfully",
                data: UserResource::collection($users)
            );
        } catch (\Throwable $th) {
            return ResponseHelper::internalServerError(
                message: "Internal Server Error",
                error: $th->getMessage()
            );
        }
    }
}

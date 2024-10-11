<?php

namespace App\Modules\UserModule\Services;

use App\Helpers\ResponseHelper;
use App\Models\User;
use Illuminate\Http\Request;

class UserDeletionService
{
    public function deleteUser(Request $request)
    {
        $user = $request->user();


        if (!$user) {
            return ResponseHelper::notFound(
                message: "User not found"
            );
        }


        $user->delete();

        return ResponseHelper::success(
            message: "User deleted successfully"
        );
    }
}

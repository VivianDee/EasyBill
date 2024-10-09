<?php

namespace App\Http\Controllers;

use App\Modules\UserModule\UserModule;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public $userModule;

    public function __construct(UserModule $userModule)
    {
        $this->userModule = $userModule;
    }

    // Get a single user by ID
    public function getUser(Request $request)
    {
        return $this->userModule->getUser($request);
    }

    // Get all users
    public function getAllUsers(Request $request)
    {
        return $this->userModule->getAllUsers($request);
    }

    // Update a user
    public function updateUser(Request $request)
    {
        return $this->userModule->updateUser($request);
    }

    // Delete a user
    public function deleteUser(Request $request)
    {
        return $this->userModule->deleteUser($request);
    }
}

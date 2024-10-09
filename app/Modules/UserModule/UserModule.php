<?php

namespace App\Modules\UserModule;

use App\Modules\UserModule\Services\UserCreationService;
use App\Modules\UserModule\Services\UserRetrievalService;
use App\Modules\UserModule\Services\UserUpdateService;
use App\Modules\UserModule\Services\UserDeletionService;
use Illuminate\Http\Request;

class UserModule
{
    public $userRetrievalService;
    public $userUpdateService;
    public $userDeletionService;

    // Constructor to initialize services
    public function __construct(
        UserRetrievalService $userRetrievalService, 
        UserUpdateService $userUpdateService, 
        UserDeletionService $userDeletionService
    ) {
        $this->userRetrievalService = $userRetrievalService;
        $this->userUpdateService = $userUpdateService;
        $this->userDeletionService = $userDeletionService;
    }

    // Handles retrieving a single user
    public function getUser(Request $request) {
        return $this->userRetrievalService->getUser($request);
    }

    // Handles retrieving all users
    public function getAllUsers(Request $request) {
        return $this->userRetrievalService->getAllUsers();
    }

    // Handles updating a user
    public function updateUser(Request $request) {
        return $this->userUpdateService->updateUser($request);
    }

    // Handles deleting a user
    public function deleteUser(Request $request) {
        return $this->userDeletionService->deleteUser($request);
    }
}
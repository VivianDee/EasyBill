<?php 

namespace App\Modules\AuthenticationModule;

use App\Modules\AuthenticationModule\Services\AccountCreationService;
use App\Modules\AuthenticationModule\Services\AccountRecoveryService;
use App\Modules\AuthenticationModule\Services\ChangePasswordService;
use App\Modules\AuthenticationModule\Services\SignInService;
use Illuminate\Http\Request;

class AuthenticationModule
{
    public $signInService;
    public $accountCreationService;
    public $changePasswordService;
    public $accountRecoveryService;

    // Constructor to initialize services
    public function __construct(SignInService $signInService, AccountCreationService $accountCreationService, ChangePasswordService $changePasswordService, AccountRecoveryService $accountRecoveryService) {
        $this->signInService = $signInService;
        $this->accountCreationService = $accountCreationService;
        $this->changePasswordService = $changePasswordService;
        $this->accountRecoveryService = $accountRecoveryService;
    }

     // Handles login
    public function login(Request $request) {
        return $this->signInService->login($request);
    }

     // Handles registeration
    public function register(Request $request) {
        return $this->accountCreationService->register($request);
    }

    // Handles Changeing of Password
    public function changePassword(Request $request) {
        return $this->changePasswordService->changePassword($request);
    }

    // Handles Changeing of Password
    public function sendOtp(Request $request) {
        return $this->accountRecoveryService->sendOtp($request);
    }

    // Handles Changeing of Password
    public function recoverAccount(Request $request) {
        return $this->accountRecoveryService->changePassword($request);
    }

    // Handles logout
    public function logout(Request $request) {
        return $this->signInService->logout($request);
    }
}
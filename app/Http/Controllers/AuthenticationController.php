<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Modules\AuthenticationModule\AuthenticationModule;

class AuthenticationController extends Controller
{
    public $authenticationModule;

    public function __construct(AuthenticationModule $authenticationModule) 
    {
        $this->authenticationModule = $authenticationModule;
    }


    // Handles login
    public function login(Request $request) {
        return $this->authenticationModule->login($request);
    }

    // Handles registeration
    public function register(Request $request) {
        return $this->authenticationModule->register($request);
    }

    // Handles Changing of Password for authenticated users
    public function changePassword(Request $request) {
        return $this->authenticationModule->changePassword($request);
    }


    // Handles Sending Otp Mail
    public function sendOtp(Request $request) {
        return $this->authenticationModule->sendOtp($request);
    }

    // Handles Changing of Password (with Otp) for unauthenticated users
    public function recoverAccount(Request $request) {
        return $this->authenticationModule->recoverAccount($request);
    }



    // Handles logout
    public function logout(Request $request) {
        return $this->authenticationModule->logout($request);
    }

}

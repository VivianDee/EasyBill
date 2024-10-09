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

    // Get Authenticated User Details
    public function showUser(Request $request)
    {
        return $this->userModule->showUser($request);
    }
}

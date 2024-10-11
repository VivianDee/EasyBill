<?php

use App\Enums\TokenAbility;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//User preference 
Route::middleware(['VerifyApiKey'])->group(function () {


    // Authentication Group
    Route::prefix("auth")->group(function () {

        Route::post("/login", [AuthenticationController::class, "login"]);
        Route::post("/register", [AuthenticationController::class, "register"]);

        //Account Recovery
        Route::prefix("recover-account")->group(function () {
            Route::post("/send-otp", [AuthenticationController::class, "sendOtp"]);
            Route::post("/change-password", [AuthenticationController::class, "recoverAccount"]);
        });


        // Routes for Authenticated Users with API Access Ability
        Route::middleware([
            "auth:sanctum",
            "ability:" . TokenAbility::ACCESS_API->value,
        ])->group(function () {
            Route::post("/logout", [AuthenticationController::class, "logout"]);
            Route::post("/change-password", [AuthenticationController::class, "changePassword"]);
        });
    });




    // Routes for Authenticated Users with API Access Ability
    Route::middleware([
        "auth:sanctum",
        "ability:" . TokenAbility::ACCESS_API->value,
    ])->group(function () {

        Route::prefix('user')->group(function () {
            // Authenticated user routes
            Route::get('/', [UserController::class, 'getUser']);
            Route::patch('/', [UserController::class, 'updateUser']);
            Route::delete('/', [UserController::class, 'deleteUser']);


            // Get any user by id
            Route::get('/{id}', [UserController::class, 'getUser']);
        });

        //get all users
        Route::get('/users', [UserController::class, 'getAllUsers']);

        Route::prefix('transaction')->group(function () {
            Route::post('/', [TransactionController::class, 'createTransaction']);
            Route::get('/{id}', [TransactionController::class, 'getTransaction']);
            Route::patch('/{id}', [TransactionController::class, 'updateTransaction']);
            Route::delete('/{id}', [TransactionController::class, 'deleteTransaction']);
        });

        //Get all transactions
        Route::get('/transactions', [TransactionController::class, 'getAllTransactions']);

    });
});

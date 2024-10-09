<?php

use App\Enums\TokenAbility;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TeamController;
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
            Route::get('/', [UserController::class, 'showUser']);
            Route::get('/{id}', [UserController::class, 'showUser']);
        });

        
        Route::prefix('tasks')->group(function () {
            Route::get('/', [TaskController::class, 'showUserTasks']);
            Route::get('/{task_id}', [TaskController::class, 'showUserTasks']); 
            Route::post('/', [TaskController::class, 'createTask']);
            Route::put('/', [TaskController::class, 'updateTask']);
            Route::put('/status', [TaskController::class, 'toggleTaskStatus']);
            Route::delete('/{task_id}', [TaskController::class, 'deleteTask']);

        });


        Route::prefix('projects')->group(function () {
            Route::get('/', [ProjectController::class, 'showUserProjects']);
            Route::get('/{project_id}', [ProjectController::class, 'showUserProjects']); 
            Route::post('/', [ProjectController::class, 'createProject']);
            Route::put('/', [ProjectController::class, 'updateProject']);
            Route::delete('/{project_id}', [ProjectController::class, 'deleteProject']);

        });

        Route::prefix('teams')->group(function () {
            Route::get('/', [TeamController::class, 'showUsersTeams']);
            Route::get('/{team_id}', [TeamController::class, 'showUsersTeams']); 
            Route::post('/', [TeamController::class, 'createTeam']);
            Route::put('/', [TeamController::class, 'updateTeam']);
            Route::delete('/{team_id}', [TeamController::class, 'deleteTeam']);

            Route::post('/assign', [TeamController::class, 'assignUserToTeam']);
        });
    });
});

<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Dashboard\BranchesController;
use App\Http\Controllers\Dashboard\Lists\BlacklistController;
use App\Http\Controllers\Dashboard\Lists\HoldlistController;
use App\Http\Controllers\Dashboard\Lists\PendinglistController;
use App\Http\Controllers\Dashboard\Lists\RefundlistController;
use App\Http\Controllers\Dashboard\Lists\WaitlistController;
use App\Http\Controllers\Dashboard\RolesController;
use App\Http\Controllers\Dashboard\Users\PendingUsersController;
use App\Http\Controllers\Dashboard\Users\UserController;
use App\Http\Controllers\Dashboard\Users\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/v1/branches', [BranchesController::class, 'viewBranches']);

Route::post('/v1/register', [RegisterController::class, 'register']);

Route::post('/v1/auth', [LoginController::class, 'login']);


Route::group(['middleware' => ['auth:sanctum']], function () {

    //Branches
    Route::get('/v1/dashboard/branches', [BranchesController::class, 'view']);
    
    Route::post('/v1/dashboard/branches/create', [BranchesController::class, 'create']);

    Route::put('/v1/dashboard/branches/{id}/update', [BranchesController::class, 'update']);

    Route::delete('/v1/dashboard/branches/{id}/delete', [BranchesController::class, 'delete']);

    Route::delete('/v1/dashboard/branches/delete', [BranchesController::class, 'bulkDelete']);

    //Roles
    Route::get('/v1/dashboard/roles', [RolesController::class, 'view']);

    Route::get('/v1/dashboard/roles/{id}/permissions', [RolesController::class, 'viewPermissions']);

    Route::post('/v1/dashboard/roles/create', [RolesController::class, 'create']);

    Route::put('/v1/dashboard/roles/{id}/update', [RolesController::class, 'update']);

    Route::delete('/v1/dashboard/roles/{id}/delete', [RolesController::class, 'delete']);

    Route::delete('/v1/dashboard/roles/delete', [RolesController::class, 'bulkDelete']);

    //users
    Route::get('/v1/dashboard/users', [UsersController::class, 'view']);

    Route::post('/v1/dashboard/users/create', [UsersController::class, 'create']);

    Route::put('/v1/dashboard/users/{id}/update', [UsersController::class, 'update']);

    Route::delete('/v1/dashboard/users/{id}/delete', [UsersController::class, 'delete']);

    Route::delete('/v1/dashboard/users/delete', [UsersController::class, 'bulkDelete']);

    //user
    Route::get('/v1/dashboard/user', [UserController::class, 'view']);

    Route::put('/v1/dashboard/user/update', [UserController::class, 'update']);

    Route::delete('/v1/dashboard/user/delete', [UserController::class, 'delete']);

    //pending users
    Route::get('/v1/dashboard/pending-users', [PendingUsersController::class, 'view']);

    Route::put('/v1/dashboard/pending-users/{id}/activate', [PendingUsersController::class, 'activate']);

    Route::put('/v1/dashboard/pending-users/activate', [PendingUsersController::class, 'bulkActivate']);

    Route::delete('/v1/dashboard/pending-users/{id}/delete', [PendingUsersController::class, 'delete']);

    Route::delete('/v1/dashboard/pending-users/delete', [PendingUsersController::class, 'bulkDelete']);

    //Lists
    //Wait List
    Route::get('/v1/dashboard/waitlist/view-trainers', [WaitlistController::class, 'viewTrainers']);
    
    Route::get('/v1/dashboard/waitlist', [WaitlistController::class, 'view']);

    Route::post('/v1/dashboard/waitlist/create', [WaitlistController::class, 'create']);

    Route::put('/v1/dashboard/waitlist/{id}/update', [WaitlistController::class, 'update']);

    Route::delete('/v1/dashboard/waitlist/{id}/delete', [WaitlistController::class, 'delete']);

    Route::delete('/v1/dashboard/waitlist/delete', [WaitlistController::class, 'bulkDelete']);

    //Pending List
    Route::get('/v1/dashboard/pendinglist/view-trainers', [PendinglistController::class, 'viewTrainers']);
    
    Route::get('/v1/dashboard/pendinglist/view-admins', [PendinglistController::class, 'viewFollowUp']);
    
    Route::get('/v1/dashboard/pendinglist', [PendinglistController::class, 'view']);

    Route::post('/v1/dashboard/pendinglist/create', [PendinglistController::class, 'create']);

    Route::put('/v1/dashboard/pendinglist/{id}/update', [PendinglistController::class, 'update']);

    Route::delete('/v1/dashboard/pendinglist/{id}/delete', [PendinglistController::class, 'delete']);

    Route::delete('/v1/dashboard/pendinglist/delete', [PendinglistController::class, 'bulkDelete']);

    //Refund List
    Route::get('/v1/dashboard/refundlist/view-trainers', [RefundlistController::class, 'viewTrainers']);
    
    Route::get('/v1/dashboard/refundlist', [RefundlistController::class, 'view']);

    Route::put('/v1/dashboard/refundlist/{id}/update', [RefundlistController::class, 'update']);

    Route::delete('/v1/dashboard/refundlist/{id}/delete', [RefundlistController::class, 'delete']);

    Route::delete('/v1/dashboard/refundlist/delete', [RefundlistController::class, 'bulkDelete']);

    //Hold List
    Route::get('/v1/dashboard/holdlist/view-trainers', [HoldlistController::class, 'viewTrainers']);
    
    Route::get('/v1/dashboard/holdlist', [HoldlistController::class, 'view']);

    Route::put('/v1/dashboard/holdlist/{id}/update', [HoldlistController::class, 'update']);

    Route::delete('/v1/dashboard/holdlist/{id}/delete', [HoldlistController::class, 'delete']);

    Route::delete('/v1/dashboard/holdlist/delete', [HoldlistController::class, 'bulkDelete']);

    //Black List
    Route::get('/v1/dashboard/blacklist/view-trainers', [BlacklistController::class, 'viewTrainers']);
    
    Route::get('/v1/dashboard/blacklist', [BlacklistController::class, 'view']);

    Route::put('/v1/dashboard/blacklist/{id}/update', [BlacklistController::class, 'update']);

    Route::delete('/v1/dashboard/blacklist/{id}/delete', [BlacklistController::class, 'delete']);

    Route::delete('/v1/dashboard/blacklist/delete', [BlacklistController::class, 'bulkDelete']);

});
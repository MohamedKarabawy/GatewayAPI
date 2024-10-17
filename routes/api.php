<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Dashboard\RolesController;
use App\Http\Controllers\Dashboard\BranchesController;
use App\Http\Controllers\Dashboard\Users\UserController;
use App\Http\Controllers\Dashboard\Users\UsersController;
use App\Http\Controllers\Dashboard\Lists\HoldlistController;
use App\Http\Controllers\Dashboard\Lists\WaitlistController;
use App\Http\Controllers\Dashboard\Batches\BatchesController;
use App\Http\Controllers\Dashboard\Lists\BlacklistController;
use App\Http\Controllers\Dashboard\Lists\RefundlistController;
use App\Http\Controllers\Dashboard\Lists\PendinglistController;
use App\Http\Controllers\Dashboard\Trainees\TraineesController;
use App\Http\Controllers\Dashboard\Users\PendingUsersController;
use App\Http\Controllers\Dashboard\Attendance\AttendanceController;
use App\Http\Controllers\Dashboard\Batches\Classes\ClassController;
use App\Http\Controllers\Dashboard\Batches\Classes\ClassesController;


Route::get('/v1/branches', [BranchesController::class, 'viewBranches']);

Route::post('/v1/register', [RegisterController::class, 'register']);

Route::post('/v1/auth', [LoginController::class, 'login']);


Route::group(['middleware' => ['auth:sanctum']], function () {

    //Branches
    Route::get('/v1/dashboard/branches', [BranchesController::class, 'view']);
    
    Route::post('/v1/dashboard/branches/create', [BranchesController::class, 'create']);

    Route::put('/v1/dashboard/branches/{id}/update', [BranchesController::class, 'update']);

    Route::delete('/v1/dashboard/branches/{id}/delete', [BranchesController::class, 'delete']);

    Route::post('/v1/dashboard/branches/delete', [BranchesController::class, 'bulkDelete']);

    //Roles
    Route::get('/v1/dashboard/roles', [RolesController::class, 'view']);

    Route::get('/v1/dashboard/roles/{id}/permissions', [RolesController::class, 'viewPermissions']);

    Route::post('/v1/dashboard/roles/create', [RolesController::class, 'create']);

    Route::put('/v1/dashboard/roles/{id}/update', [RolesController::class, 'update']);

    Route::delete('/v1/dashboard/roles/{id}/delete', [RolesController::class, 'delete']);

    Route::post('/v1/dashboard/roles/delete', [RolesController::class, 'bulkDelete']);

    //users
    Route::get('/v1/dashboard/users', [UsersController::class, 'view']);

    Route::get('/v1/dashboard/users/roles', [UsersController::class, 'viewRoles']);

    Route::post('/v1/dashboard/users/create', [UsersController::class, 'create']);

    Route::put('/v1/dashboard/users/{id}/update', [UsersController::class, 'update']);

    Route::delete('/v1/dashboard/users/{id}/delete', [UsersController::class, 'delete']);

    Route::post('/v1/dashboard/users/delete', [UsersController::class, 'bulkDelete']);

    //user
    Route::get('/v1/dashboard/user', [UserController::class, 'view']);

    Route::put('/v1/dashboard/user/update', [UserController::class, 'update']);

    Route::delete('/v1/dashboard/user/delete', [UserController::class, 'delete']);

    //pending users
    Route::get('/v1/dashboard/pending-users', [PendingUsersController::class, 'view']);

    Route::put('/v1/dashboard/pending-users/{id}/activate', [PendingUsersController::class, 'activate']);

    Route::put('/v1/dashboard/pending-users/activate', [PendingUsersController::class, 'bulkActivate']);

    Route::delete('/v1/dashboard/pending-users/{id}/delete', [PendingUsersController::class, 'delete']);

    Route::post('/v1/dashboard/pending-users/delete', [PendingUsersController::class, 'bulkDelete']);

    //Trainees
    Route::get('/v1/dashboard/trainees', [TraineesController::class, 'view']);

    //Lists
    //Wait List
    Route::post('/v1/dashboard/waitlist/level/add', [WaitlistController::class, 'addLevel']);

    Route::post('/v1/dashboard/waitlist/payment/add', [WaitlistController::class, 'addPayment']);

    Route::post('/v1/dashboard/waitlist/time/add', [WaitlistController::class, 'addTime']);

    Route::get('/v1/dashboard/waitlist/levels', [WaitlistController::class, 'viewLevels']);

    Route::get('/v1/dashboard/waitlist/payments', [WaitlistController::class, 'viewPayment']);

    Route::get('/v1/dashboard/waitlist/times', [WaitlistController::class, 'viewTimes']);

    Route::put('/v1/dashboard/waitlist/class/view-classes', [WaitlistController::class, 'viewClasses']);

    Route::get('/v1/dashboard/waitlist/class/view-classes-levels', [WaitlistController::class, 'viewClassesLevels']);

    Route::get('/v1/dashboard/waitlist/class/view-classes-times', [WaitlistController::class, 'viewClassesTimes']);

    Route::post('/v1/dashboard/waitlist/{trainee_id}/assign-class', [WaitlistController::class, 'assignClass']);

    Route::put('/v1/dashboard/waitlist/hold', [WaitlistController::class, 'bulkMoveToHold']);

    Route::put('/v1/dashboard/waitlist/refund', [WaitlistController::class, 'bulkMoveToRefund']);

    Route::put('/v1/dashboard/waitlist/black', [WaitlistController::class, 'bulkMoveToBlack']);
    
    Route::put('/v1/dashboard/waitlist/{id}/hold', [WaitlistController::class, 'moveToHold']);

    Route::put('/v1/dashboard/waitlist/{id}/refund', [WaitlistController::class, 'moveToRefund']);

    Route::put('/v1/dashboard/waitlist/{id}/black', [WaitlistController::class, 'moveToBlack']);

    Route::get('/v1/dashboard/waitlist/view-trainers', [WaitlistController::class, 'viewTrainers']);
    
    Route::get('/v1/dashboard/waitlist', [WaitlistController::class, 'view']);

    Route::post('/v1/dashboard/waitlist/create', [WaitlistController::class, 'create']);

    Route::put('/v1/dashboard/waitlist/{id}/update', [WaitlistController::class, 'update']);

    Route::delete('/v1/dashboard/waitlist/{id}/delete', [WaitlistController::class, 'delete']);

    Route::post('/v1/dashboard/waitlist/delete', [WaitlistController::class, 'bulkDelete']);

    //Pending List
    Route::post('/v1/dashboard/pendinglist/payment/add', [PendinglistController::class, 'addPayment']);

    Route::post('/v1/dashboard/pendinglist/level/add', [PendinglistController::class, 'addLevel']);

    Route::get('/v1/dashboard/pendinglist/payments', [PendinglistController::class, 'viewPayment']);

    Route::get('/v1/dashboard/pendinglist/levels', [PendinglistController::class, 'viewLevels']);
    
    Route::get('/v1/dashboard/pendinglist/view-trainers', [PendinglistController::class, 'viewTrainers']);
    
    Route::get('/v1/dashboard/pendinglist/view-admins', [PendinglistController::class, 'viewFollowUp']);
    
    Route::put('/v1/dashboard/pendinglist/{trainee_id}/assign-trainer', [PendinglistController::class, 'assignTrainer']);

    Route::put('/v1/dashboard/pendinglist/{trainee_id}/assign-level', [PendinglistController::class, 'assignLevel']);
    
    Route::get('/v1/dashboard/pendinglist', [PendinglistController::class, 'view']);

    Route::post('/v1/dashboard/pendinglist/create', [PendinglistController::class, 'create']);

    Route::put('/v1/dashboard/pendinglist/{id}/update', [PendinglistController::class, 'update']);

    Route::delete('/v1/dashboard/pendinglist/{id}/delete', [PendinglistController::class, 'delete']);

    Route::post('/v1/dashboard/pendinglist/delete', [PendinglistController::class, 'bulkDelete']);

    //Refund List
    Route::put('/v1/dashboard/refundlist/{id}/wait', [RefundlistController::class, 'moveToWait']);

    Route::put('/v1/dashboard/refundlist/wait', [RefundlistController::class, 'bulkMoveToWait']);

    Route::get('/v1/dashboard/refundlist/view-trainers', [RefundlistController::class, 'viewTrainers']);
    
    Route::get('/v1/dashboard/refundlist', [RefundlistController::class, 'view']);

    Route::put('/v1/dashboard/refundlist/{id}/update', [RefundlistController::class, 'update']);

    Route::delete('/v1/dashboard/refundlist/{id}/delete', [RefundlistController::class, 'delete']);

    Route::post('/v1/dashboard/refundlist/delete', [RefundlistController::class, 'bulkDelete']);

    //Hold List
    Route::put('/v1/dashboard/holdlist/{id}/wait', [HoldlistController::class, 'moveToWait']);

    Route::put('/v1/dashboard/holdlist/wait', [HoldlistController::class, 'bulkMoveToWait']);
    
    Route::get('/v1/dashboard/holdlist/view-trainers', [HoldlistController::class, 'viewTrainers']);
    
    Route::get('/v1/dashboard/holdlist', [HoldlistController::class, 'view']);

    Route::put('/v1/dashboard/holdlist/{id}/update', [HoldlistController::class, 'update']);

    Route::delete('/v1/dashboard/holdlist/{id}/delete', [HoldlistController::class, 'delete']);

    Route::post('/v1/dashboard/holdlist/delete', [HoldlistController::class, 'bulkDelete']);

    //Black List
    Route::put('/v1/dashboard/blacklist/{id}/wait', [BlacklistController::class, 'moveToWait']);

    Route::put('/v1/dashboard/blacklist/wait', [BlacklistController::class, 'bulkMoveToWait']);
    
    Route::get('/v1/dashboard/blacklist/view-trainers', [BlacklistController::class, 'viewTrainers']);
    
    Route::get('/v1/dashboard/blacklist', [BlacklistController::class, 'view']);

    Route::put('/v1/dashboard/blacklist/{id}/update', [BlacklistController::class, 'update']);

    Route::delete('/v1/dashboard/blacklist/{id}/delete', [BlacklistController::class, 'delete']);

    Route::post('/v1/dashboard/blacklist/delete', [BlacklistController::class, 'bulkDelete']);

    //Batches
    Route::put('/v1/dashboard/batches/{id}/activate', [BatchesController::class, 'activate']);
    
    Route::put('/v1/dashboard/batches/{id}/end', [BatchesController::class, 'end']);

    Route::get('/v1/dashboard/batches', [BatchesController::class, 'view']);

    Route::post('/v1/dashboard/batches/create', [BatchesController::class, 'create']);

    Route::put('/v1/dashboard/batches/{id}/update', [BatchesController::class, 'update']);

    Route::delete('/v1/dashboard/batches/{id}/delete', [BatchesController::class, 'delete']);

    //Classes
    Route::post('/v1/dashboard/batches/{class_id}/classes/{trainee_id}/add-to-attendance', [AttendanceController::class, 'addToAttendance']);

    Route::get('/v1/dashboard/batches/{class_id}/classes/{trainee_id}/view-admin-note', [ClassController::class, 'viewAdminNote']);

    Route::get('/v1/dashboard/batches/{class_id}/classes/{trainee_id}/view-trainer-note', [ClassController::class, 'viewTrainerNote']);
    
    Route::put('/v1/dashboard/batches/{class_id}/classes/{trainee_id}/add-admin-note', [ClassController::class, 'addAdminNote']);

    Route::put('/v1/dashboard/batches/{class_id}/classes/{trainee_id}/add-trainer-note', [ClassController::class, 'addTrainerNote']);

    Route::get('/v1/dashboard/batches/{batch_id}/view-select-classes', [ClassController::class, 'viewClasses']);

    Route::put('/v1/dashboard/batches/{class_id}/classes/{trainee_id}/move-to-black', [ClassesController::class, 'moveToBlack']);

    Route::put('/v1/dashboard/batches/{class_id}/classes/{trainee_id}/move-to-hold', [ClassesController::class, 'moveToHold']);

    Route::put('/v1/dashboard/batches/{class_id}/classes/{trainee_id}/move-to-refund', [ClassesController::class, 'moveToRefund']);

    Route::put('/v1/dashboard/batches/{class_id}/classes/{trainee_id}/move-to-wait', [ClassesController::class, 'moveToWait']);

    Route::put('/v1/dashboard/batches/classes/{trainee_id}/switch-class', [ClassesController::class, 'switchClass']);

    Route::get('/v1/dashboard/batches/{batch_id}/classes/{class_id}', [ClassController::class, 'viewClass']);
    
    Route::post('/v1/dashboard/batches/classes/gate/add', [ClassesController::class, 'createGate']);

    Route::post('/v1/dashboard/batches/classes/level/add', [ClassesController::class, 'createLevel']);

    Route::post('/v1/dashboard/batches/classes/time-slot/add', [ClassesController::class, 'createTimeSlot']);

    Route::get('/v1/dashboard/batches/classes/trainers', [ClassesController::class, 'viewTrainers']);
    
    Route::get('/v1/dashboard/batches/classes/gates', [ClassesController::class, 'viewGates']);

    Route::get('/v1/dashboard/batches/classes/levels', [ClassesController::class, 'viewLevels']);

    Route::get('/v1/dashboard/batches/classes/time-slots', [ClassesController::class, 'viewTimeSlots']);

    Route::get('/v1/dashboard/batches/{batch_id}/classes', [ClassesController::class, 'viewClasses']);

    Route::post('/v1/dashboard/batches/{batch_id}/classes/create', [ClassesController::class, 'createClass']);

    Route::put('/v1/dashboard/batches/{batch_id}/classes/{id}/update', [ClassesController::class, 'updateClass']);

    Route::delete('/v1/dashboard/batches/{batch_id}/classes/{class_id}/delete', [ClassesController::class, 'deleteClass']);

    //Attendance
    Route::get('/v1/dashboard/batches/classes/{class_id}/attendance', [AttendanceController::class, 'view']);
});
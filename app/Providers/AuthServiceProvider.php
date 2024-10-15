<?php

namespace App\Providers;

use App\Models\Role;
use App\Models\User;
use App\Models\Batch;
use App\Models\Branch;
use App\Models\Classes;
use App\Models\Trainee;
use App\Models\Attendance;
use App\Policies\RolePolicy;
use App\Policies\UserPolicy;
use App\Policies\BatchPolicy;
use App\Policies\BranchPolicy;
use App\Policies\ClassesPolicy;
use App\Policies\TraineePolicy;
use App\Policies\AttendancePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{

    protected $policies = [
        Trainee::class => TraineePolicy::class,
        Branch::class => BranchPolicy::class,
        Role::class => RolePolicy::class,
        User::class => UserPolicy::class,
        Batch::class => BatchPolicy::class,
        Classes::class => ClassesPolicy::class,
        Attendance::class => AttendancePolicy::class
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
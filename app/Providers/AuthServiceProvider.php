<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Trainee;
use App\Models\Branch;
use App\Models\Role;
use App\Models\User;
use App\Policies\TraineePolicy;
use App\Policies\BranchPolicy;
use App\Policies\RolePolicy;
use App\Policies\UserPolicy;

class AuthServiceProvider extends ServiceProvider
{

    protected $policies = [
        Trainee::class => TraineePolicy::class,
        Branch::class => BranchPolicy::class,
        Role::class => RolePolicy::class,
        User::class => UserPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Trainee;
use App\Policies\TraineePolicy;

class AuthServiceProvider extends ServiceProvider
{

    protected $policies = [
        Trainee::class => TraineePolicy::class,
        User::class => BranchPolicy::class,
        User::class => RolePolicy::class,
        User::class => PendingUserPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
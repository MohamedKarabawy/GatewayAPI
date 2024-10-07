<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Policies\BranchPolicy;
use App\Policies\RolePolicy;
use App\Policies\PendingUserPolicy;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {

    }

    public function boot(): void
    {
        Gate::policy(User::class, BranchPolicy::class);

        Gate::policy(User::class, RolePolicy::class);

        Gate::policy(User::class, PendingUserPolicy::class);
    }
}
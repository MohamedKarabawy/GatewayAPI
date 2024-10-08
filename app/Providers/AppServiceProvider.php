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
      
    }
}
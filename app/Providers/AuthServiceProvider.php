<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\Page' => 'App\Policies\PagePolicy',
        'App\Models\Post' => 'App\Policies\PostPolicy',
        'App\Models\User' => 'App\Policies\UserPolicy',
        'App\Models\Setting' => 'App\Policies\SettingPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Implicitly grant "super_admin" role all permission checks using can()
        Gate::before(function ($user, $ability) {
            if ($user->hasRole('super_admin')) {
                return true;
            }
        });
    }
}

<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Post;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Post::class => PostPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();

        // Define gates
        Gate::before(function ($user, $ability) {
            if ($user->hasRole('admin')) {
                return true;
            }
        });

        // Define permission-based gates
        $permissions = \App\Models\Permission::all();
        foreach ($permissions as $permission) {
            Gate::define($permission->name, function (User $user) use ($permission) {
                return $user->hasPermission($permission);
            });
        }

        // Define role-based gates
        Gate::define('is-admin', function (User $user) {
            return $user->hasRole('admin');
        });

        Gate::define('is-editor', function (User $user) {
            return $user->hasRole('editor') || $user->hasRole('admin');
        });

        Gate::define('is-author', function (User $user) {
            return $user->hasRole('author') || $user->hasRole('editor') || $user->hasRole('admin');
        });
    }
}

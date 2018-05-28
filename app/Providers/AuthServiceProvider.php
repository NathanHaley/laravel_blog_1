<?php

namespace App\Providers;

use App\Permission;
use App\Post;
use App\User;
use App\Channel;
use App\Comment;

use App\Policies\PostPolicy;
use App\Policies\UserPolicy;
use App\Policies\ChannelPolicy;
use App\Policies\CommentPolicy;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Post::class => PostPolicy::class,
        User::class => UserPolicy::class,
        Comment::class => CommentPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {

        Gate::before(function ($user) {
            if ($user->isAdmin()) return true;
        });

        foreach ($this->getPermissions() as $permission) {
            Gate::define($permission->name, function ($user) use ($permission){
                return $user->hasPermission($permission);
            });
         }

        $this->registerPolicies();

        //
    }

    /**
     * Fetch the collection of site permissions.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function getPermissions()
    {
        return Permission::with('roles')->get();
    }
}

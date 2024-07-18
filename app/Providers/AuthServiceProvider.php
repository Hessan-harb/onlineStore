<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('categories.view',function($user){
            return true;
        });

        Gate::define('categories.create',function($user){
            return false;
        });

        Gate::define('categories.update',function($user){
            return true;
        });

        Gate::define('categories.delete',function($user){
            return false;
     });
//////////////// if you wanna contiune viedo number 16.1 to min 1:17:03

        Gate::define('products.view',function($user){
            return true;
        });

        // Gate::define('orders.view',function($user){
        //     return false;
        // });

        // Gate::define('categories.update',function($user){
        //     return true;
        // });

        // Gate::define('categories.delete',function($user){
        //     return false;
        // });
    }
}

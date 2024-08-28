<?php

namespace App\Providers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Validators\ReCaptcha;
use App\Observers\ModelObserver;
use App\Models\Order;

use Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(Request $request): void
    {
        // 
        Order::observe(ModelObserver::class);


        if (app()->environment('production')) {
            $this->app['request']->server->set('HTTPS', true);
        }
        Schema::defaultStringLength(191);
        $this->app->singleton('User_permission', function ($app) {

            if (auth()->user()) {

                if (auth()->user()->user_type == 'admin' || auth()->user()->user_type == 'super_admin') {

                    if (auth()->user()->role_id == null) {

                        abort(403, 'Access Denied');
                    }

                    $role = Role::findOrFail(auth()->user()->role_id);

                    $permissions = $role->permissions;
                    $permissionsTitle = [];
                    foreach ($permissions as $permission) {
                        $permissionsTitle[] = $permission->title;
                    }

                    return $permissionsTitle;
                }

            }
        });

        //

        Validator::extend('recaptcha', 'App\\Validators\\ReCaptcha@validate');


        //

    }
}

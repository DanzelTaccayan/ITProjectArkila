<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use App\Member;

use App\Van;
use App\User;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();

        Route::bind('operator',function($value){
            return Member::allOperators()->where('member_id',$value)->where('status','Active')->first() ?? abort(404);
        });

        Route::bind('driver', function($value){
            return Member::allDrivers()->where('member_id',$value)->where('status','Active')->first() ?? abort(404);
        });

        Route::bind('van', function($value){
            return Van::where('van_id',$value)->where('status','Active')->first() ?? abort(404);
        });

        Route::bind('archivedOperator', function($value){
           return Member::allOperators()->where('status','Inactive')->where('member_id',$value)->first() ?? abort(404);
        });

        Route::bind('archivedDriver', function($value){
            return Member::allDrivers()->where('status','Inactive')->where('member_id',$value)->first() ?? abort(404);
        });

        Route::bind('archivedVan', function($value){
            return Van::where('van_id',$value)->where('status','Inactive')->first() ?? abort(404);
        });

        Route::bind('generalDriver', function($value){
            return Member::allDrivers()->where('member_id',$value)->first() ?? abort(404);
        });

        Route::bind('driver_user', function($value){
            return User::driver()->where('id',$value)->first() ?? abort(404);
        });

        Route::bind('customer_user', function($value){
            return User::customer()->where('id',$value)->first() ?? abort(404);
        });

        Route::bind('admin_user', function($value){
            return User::admin()->where('id',$value)->first() ?? abort(404);
        });
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }
}

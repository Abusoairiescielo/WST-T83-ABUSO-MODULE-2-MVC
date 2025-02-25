<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * @var string
     */
    public const HOME = '/dashboard';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        parent::boot();
        
        $this->app['router']->aliasMiddleware('user.type', \App\Http\Middleware\CheckUserType::class);
        
        $this->routes(function () {
            if (file_exists(base_path('routes/api.php'))) {
                Route::middleware('api')
                    ->prefix('api')
                    ->group(base_path('routes/api.php'));
            }

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Determine where to redirect users after authentication.
     */
    public static function redirectTo()
    {
        if (Auth::user() && Auth::user()->user_type === 'student') {
            return '/student/dashboard';
        }
        return self::HOME;
    }
}
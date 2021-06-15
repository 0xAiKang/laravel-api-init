<?php

namespace App\Providers;

use Illuminate\Routing\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // 添加场景验证 scene 方法
        Route::macro('scene', function ($scene = null) {
            $action = Route::getAction();
            $action['_scene'] = $scene;
            Route::setAction($action);
        });
    }
}

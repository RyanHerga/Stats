<?php

namespace Modules\Stats\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Route;


class StatsServiceProvider extends ServiceProvider
{
    protected $defer = false;
    protected $moduleSvc;

    /**
     * Boot the application events.
     */
    public function boot()
    {
        $this->moduleSvc = app('App\Services\ModuleService');

        $this->registerRoutes();
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();

        $this->registerLinks();

        $this->registerFactories();
        $this->loadMigrationsFrom(__DIR__ . '/../Database/migrations');
    }
 
    /**
     * Add module links here
     */
    public function registerLinks()
    {
        // Show this link if logged in
        $this->moduleSvc->addFrontendLink('Stats', '/stats', '', $logged_in=true);

        // Admin links:
        $this->moduleSvc->addAdminLink('Stats', '/admin/stats');
    }

    /**
     * Register the routes
     */
    protected function registerRoutes()
    {
        /**
         * Routes for the frontend
         */
        Route::group([
            'as' => 'stats.',
            'prefix' => 'stats',
            // If you want a RESTful module, change this to 'api'
            'middleware' => ['web'],
            'namespace' => 'Modules\Stats\Http\Controllers'
        ], function() {
            $this->loadRoutesFrom(__DIR__ . '/../Http/Routes/web.php');
        });

        /**
         * Routes for the admin
         */
        Route::group([
            'as' => 'stats.',
            'prefix' => 'admin/stats',
            // If you want a RESTful module, change this to 'api'
            'middleware' => ['web', 'role:admin'],
            'namespace' => 'Modules\Stats\Http\Controllers\Admin'
        ], function() {
            $this->loadRoutesFrom(__DIR__ . '/../Http/Routes/admin.php');
        });

        /**
         * Routes for an API
         */
        Route::group([
            'as' => 'stats.',
            'prefix' => 'api/stats',
            // If you want a RESTful module, change this to 'api'
            'middleware' => ['api'],
            'namespace' => 'Modules\Stats\Http\Controllers\Api'
        ], function() {
            $this->loadRoutesFrom(__DIR__ . '/../Http/Routes/api.php');
        });
    }

    /**
     * Register config.
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('stats.php'),
        ], 'stats');

        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'stats'
        );
    }

    /**
     * Register views.
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/stats');
        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/stats';
        }, \Config::get('view.paths')), [$sourcePath]), 'stats');
    }

    /**
     * Register translations.
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/stats');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'stats');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'stats');
        }
    }

    /**
     * Register an additional directory of factories.
     * @source https://github.com/sebastiaanluca/laravel-resource-flow/blob/develop/src/Modules/ModuleServiceProvider.php#L66
     */
    public function registerFactories()
    {
        if (! app()->environment('production')) {
            app(Factory::class)->load(__DIR__ . '/../Database/factories');
        }
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides()
    {
        return [];
    }
}

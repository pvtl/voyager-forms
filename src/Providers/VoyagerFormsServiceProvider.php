<?php

namespace Pvtl\VoyagerForms\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Pvtl\VoyagerForms\Forms;
use Pvtl\VoyagerForms\Commands;
use Pvtl\VoyagerForms\Facades\Forms as FormsFacade;

class VoyagerFormsServiceProvider extends ServiceProvider
{
    /**
     * Our root directory for this package to make traversal easier
     */
    const PACKAGE_DIR = __DIR__ . '/../../';

    /**
     * Bootstrap the application services
     *
     * @return void
     */
    public function boot()
    {
        $this->strapRoutes();
        $this->strapPublishers();
        $this->strapViews();
        $this->strapHelpers();
        $this->strapMigrations();
        $this->strapCommands();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap our Routes
     */
    protected function strapRoutes()
    {
        $this->loadRoutesFrom(self::PACKAGE_DIR . 'routes/web.php');
    }

    /**
     * Bootstrap our Publishers
     */
    protected function strapPublishers()
    {
        // Defines which files to copy the root project
        $this->publishes([
            self::PACKAGE_DIR . 'config' => base_path('config'),
        ]);
    }

    /**
     * Bootstrap our Views
     */
    protected function strapViews()
    {
        $this->loadViewsFrom(self::PACKAGE_DIR . 'resources/views', 'voyager-forms');
        $this->loadViewsFrom(self::PACKAGE_DIR . 'resources/views/vendor/voyager', 'voyager');
    }

    /**
     * Load helpers.
     */
    protected function strapHelpers()
    {
        foreach (glob(self::PACKAGE_DIR . '/src/Helpers/*.php') as $filename) {
            require_once $filename;
        }
    }

    /**
     * Bootstrap our Migrations
     */
    protected function strapMigrations()
    {
        // Load migrations
        $this->loadMigrationsFrom(self::PACKAGE_DIR . 'database/migrations');

        // Locate our factories for testing
        $this->app->make('Illuminate\Database\Eloquent\Factory')->load(
            self::PACKAGE_DIR . 'database/factories'
        );
    }

    /**
     * Bootstrap our Commands/Schedules
     */
    protected function strapCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\InstallCommand::class
            ]);
        }
    }
}

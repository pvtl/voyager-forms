<?php

namespace Pvtl\VoyagerForms\Providers;

use Pvtl\VoyagerForms\Commands;
use Illuminate\Support\ServiceProvider;

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
    }

    /**
     * Bootstrap our Views
     */
    protected function strapViews()
    {
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

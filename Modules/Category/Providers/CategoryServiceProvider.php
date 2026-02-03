<?php

namespace Modules\Category\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Finder\Finder;

class CategoryServiceProvider extends ServiceProvider
{
    /**
     * @var string
     */
    protected $moduleName = 'Category';

    /**
     * @var string
     */
    protected $moduleNameLower = 'category';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();

        // Load migrations from module
        $this->loadMigrationsFrom(base_path('Modules/Category/database/migrations'));

        // Publish migrations with proper tags
        if ($this->app->runningInConsole()) {
            $this->publishes([
                base_path('Modules/Category/database/migrations') => database_path('migrations'),
            ], ['migrations', 'category-migrations']);
        }

        // register commands
        $this->registerCommands('\Modules\Category\Console\Commands');

        // Register seeders
        $this->registerSeeders();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);

        // Event Service Provider
        $this->app->register(EventServiceProvider::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $configPath = base_path('Modules/Category/Config/config.php');

        // Merge config from module (package defaults)
        $this->mergeConfigFrom($configPath, $this->moduleNameLower);

        // Publish config for customization
        if ($this->app->runningInConsole()) {
            $this->publishes([
                $configPath => config_path($this->moduleNameLower.'.php'),
            ], ['config', 'category-config', 'category-module-config']);
        }
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $sourcePath = base_path('Modules/Category/Resources/views');

        // Load views from module with 'category' namespace
        $this->loadViewsFrom($sourcePath, $this->moduleNameLower);

        // Publish views for customization
        if ($this->app->runningInConsole()) {
            $this->publishes([
                $sourcePath => resource_path('views/vendor/'.$this->moduleNameLower),
            ], ['views', 'category-views', 'category-module-views']);
        }
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $this->loadTranslationsFrom(__DIR__.'/../lang', 'category');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    /**
     * Register commands.
     *
     * @param  string  $namespace
     */
    protected function registerCommands($namespace = '')
    {
        $finder = new Finder; // from Symfony\Component\Finder;
        $finder->files()->name('*.php')->in(__DIR__.'/../Console');

        $classes = [];
        foreach ($finder as $file) {
            $class = $namespace.'\\'.$file->getBasename('.php');
            array_push($classes, $class);
        }

        $this->commands($classes);
    }

    /**
     * Register module seeders.
     *
     * @return void
     */
    protected function registerSeeders()
    {
        // Publish seeders so they can be customized
        if ($this->app->runningInConsole()) {
            $this->publishes([
                base_path('Modules/'.$this->moduleName.'/database/seeders') => database_path('seeders/'.$this->moduleName),
            ], ['seeders', 'category-seeders']);
        }

        // Register the seeder in the container for automatic discovery
        $this->app->singleton($this->moduleNameLower.'.database.seeder', function () {
            return 'Modules\\'.$this->moduleName.'\\database\\seeders\\'.$this->moduleName.'DatabaseSeeder';
        });
    }
}

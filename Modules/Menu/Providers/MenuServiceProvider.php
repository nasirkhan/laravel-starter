<?php

namespace Modules\Menu\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Modules\Menu\Livewire\MenuItemComponent;
use Modules\Menu\Models\Menu;
use Modules\Menu\Models\MenuItem;
use Modules\Menu\Observers\MenuItemObserver;
use Modules\Menu\Observers\MenuObserver;
use Symfony\Component\Finder\Finder;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * @var string
     */
    protected $moduleName = 'Menu';

    /**
     * @var string
     */
    protected $moduleNameLower = 'menu';

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
        $this->loadMigrationsFrom(base_path('Modules/Menu/database/migrations'));

        // Publish migrations with proper tags
        if ($this->app->runningInConsole()) {
            $this->publishes([
                base_path('Modules/Menu/database/migrations') => database_path('migrations'),
            ], ['migrations', 'menu-migrations']);
        }

        // register commands
        $this->registerCommands('\Modules\Menu\Console\Commands');

        $this->registerLivewireComponents();

        // Register seeders
        $this->registerSeeders();

        // Register model observers for automatic cache clearing
        $this->registerObservers();
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
        $configPath = base_path('Modules/Menu/Config/config.php');

        // Merge config from module (package defaults)
        $this->mergeConfigFrom($configPath, $this->moduleNameLower);

        // Publish config for customization
        if ($this->app->runningInConsole()) {
            $this->publishes([
                $configPath => config_path($this->moduleNameLower.'.php'),
            ], ['config', 'menu-config', 'menu-module-config']);
        }
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $sourcePath = base_path('Modules/Menu/Resources/views');

        // Load views from module with 'menu' namespace
        $this->loadViewsFrom($sourcePath, $this->moduleNameLower);

        // Publish views for customization
        if ($this->app->runningInConsole()) {
            $this->publishes([
                $sourcePath => resource_path('views/vendor/'.$this->moduleNameLower),
            ], ['views', 'menu-views', 'menu-module-views']);
        }
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $this->loadTranslationsFrom(__DIR__.'/../lang', 'menu');
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
     * Register Livewire components.
     *
     * @return void
     */
    protected function registerLivewireComponents()
    {
        // Register with proper namespace for module (use dot notation)
        Livewire::component('menu.menu-item-component', MenuItemComponent::class);

        // Publish Livewire components (both class and view) for full customization
        if ($this->app->runningInConsole()) {
            $this->publishes([
                base_path('Modules/Menu/Livewire') => app_path('Livewire/Menu'),
                base_path('Modules/Menu/Resources/views/livewire') => resource_path('views/livewire/menu'),
            ], ['menu-livewire-components']);
        }
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
            ], ['seeders', 'menu-seeders']);
        }

        // Register the seeder in the container for automatic discovery
        $this->app->singleton($this->moduleNameLower.'.database.seeder', function () {
            return 'Modules\\'.$this->moduleName.'\\database\\seeders\\'.$this->moduleName.'DatabaseSeeder';
        });

        // Register a console command for seeding
        if ($this->app->runningInConsole()) {
            $this->commands([
                \Modules\Menu\Console\Commands\SeedMenuCommand::class,
            ]);
        }
    }

    /**
     * Register model observers for automatic cache clearing.
     *
     * @return void
     */
    protected function registerObservers()
    {
        Menu::observe(MenuObserver::class);
        MenuItem::observe(MenuItemObserver::class);
    }
}

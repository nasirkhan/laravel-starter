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
        $this->loadMigrationsFrom(base_path('Modules/Menu/database/migrations'));

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
        $this->publishes([
            base_path('Modules/Menu/Config/config.php') => config_path($this->moduleNameLower.'.php'),
        ], 'config');
        $this->mergeConfigFrom(
            base_path('Modules/Menu/Config/config.php'), $this->moduleNameLower
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/'.$this->moduleNameLower);

        $sourcePath = base_path('Modules/Menu/Resources/views');

        $this->publishes([
            $sourcePath => $viewPath,
        ], ['views', $this->moduleNameLower.'-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);
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

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        // Use app configuration for view paths, fallback to default
        $viewPaths = $this->app['config']['view.paths'] ?? [resource_path('views')];
        foreach ($viewPaths as $path) {
            if (is_dir($path.'/modules/'.$this->moduleNameLower)) {
                $paths[] = $path.'/modules/'.$this->moduleNameLower;
            }
        }

        return $paths;
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
        Livewire::component('menu-item-component', MenuItemComponent::class);
    }

    /**
     * Register module seeders.
     *
     * @return void
     */
    protected function registerSeeders()
    {
        // Publish seeders so they can be customized
        $this->publishes([
            base_path('Modules/'.$this->moduleName.'/database/seeders') => database_path('seeders/'.$this->moduleName),
        ], $this->moduleNameLower.'-seeders');

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

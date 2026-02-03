<?php

namespace Modules\Post\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Modules\Post\Livewire\Frontend\RecentPosts;
use Symfony\Component\Finder\Finder;

class PostServiceProvider extends ServiceProvider
{
    /**
     * @var string
     */
    protected $moduleName = 'Post';

    /**
     * @var string
     */
    protected $moduleNameLower = 'post';

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
        $this->loadMigrationsFrom(base_path('Modules/Post/database/migrations'));

        // Publish migrations with proper tags
        if ($this->app->runningInConsole()) {
            $this->publishes([
                base_path('Modules/Post/database/migrations') => database_path('migrations'),
            ], ['migrations', 'post-migrations']);
        }

        // register commands
        $this->registerCommands('\Modules\Post\Console\Commands');

        // Register seeders
        $this->registerSeeders();

        // register Livewire components
        $this->registerLivewireComponents();
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
        $configPath = base_path('Modules/Post/Config/config.php');

        // Merge config from module (package defaults)
        $this->mergeConfigFrom($configPath, $this->moduleNameLower);

        // Publish config for customization
        if ($this->app->runningInConsole()) {
            $this->publishes([
                $configPath => config_path($this->moduleNameLower.'.php'),
            ], ['config', 'post-config', 'post-module-config']);
        }
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $sourcePath = base_path('Modules/Post/Resources/views');

        // Load views from module with 'post' namespace
        $this->loadViewsFrom($sourcePath, $this->moduleNameLower);

        // Publish views for customization
        if ($this->app->runningInConsole()) {
            // Publish all views
            $this->publishes([
                $sourcePath => resource_path('views/vendor/'.$this->moduleNameLower),
            ], ['views', 'post-views', 'post-module-views']);

            // Publish Livewire views specifically
            $this->publishes([
                $sourcePath.'/livewire' => resource_path('views/vendor/'.$this->moduleNameLower.'/livewire'),
            ], ['post-livewire-views']);
        }
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $this->loadTranslationsFrom(__DIR__.'/../lang', 'post');
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
            ], ['seeders', 'post-seeders']);
        }

        // Register the seeder in the container for automatic discovery
        $this->app->singleton($this->moduleNameLower.'.database.seeder', function () {
            return 'Modules\\'.$this->moduleName.'\\database\\seeders\\'.$this->moduleName.'DatabaseSeeder';
        });
    }

    /**
     * Register Livewire components.
     *
     * @return void
     */
    protected function registerLivewireComponents()
    {
        // Register with proper namespace for module (use dot notation)
        Livewire::component('post.frontend-recent-posts', RecentPosts::class);

        // Publish Livewire components (both class and view) for full customization
        if ($this->app->runningInConsole()) {
            $this->publishes([
                base_path('Modules/Post/Livewire') => app_path('Livewire/Post'),
                base_path('Modules/Post/Resources/views/livewire') => resource_path('views/livewire/post'),
            ], ['post-livewire-components']);
        }
    }
}

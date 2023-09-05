<?php

namespace App\Providers;

use Hexadog\MenusManager\Facades\MenusManager;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        // load Backend Sidebar Menu
        $this->buildBackendMenu();
    }

    public function buildBackendMenu(): void
    {
        $menu = MenusManager::register('backend_sidebar');

        // $menu->route('frontend.index', __('Home Page'))->icon('nav-icon fa-solid fa-cubes')->order(1);
        $menu->route('frontend.index', __('Home Page'))->order(1);

        $menu->route('backend.dashboard', __('Backend'))->if(fn () => Auth()->check() && Auth()->user()->can('view_backend'));
    }
}

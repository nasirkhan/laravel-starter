<?php

namespace App\Providers;

use Hexadog\MenusManager\Facades\MenusManager;
use Illuminate\Support\Facades\Auth;
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

        $menu->route('backend.dashboard', __('Dashboard'))->icon('nav-icon fa-solid fa-cubes')->order(1);

        // dd(auth()->user());
        $menu->header('Management')->order(100);
        // $menu->route('backend.dashboard', __('Notifications'))->icon('nav-icon fas fa-bell')->order(101)->if(Auth()->user()->can('edit_settings'));
    }
}

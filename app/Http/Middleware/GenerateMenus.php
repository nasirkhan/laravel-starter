<?php

namespace App\Http\Middleware;

use Closure;

class GenerateMenus
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        \Menu::make('admin_sidebar', function ($menu) {
            // Dashboard
            $menu->add('<i class="icon-speedometer"></i> Dashboard', [
                'route' => 'backend.dashboard',
                'class' => 'nav-item',
            ])
            ->data('order', 1)
            ->link->attr([
                'class' => 'nav-link',
            ]);

            // Separator: Access Management
            $menu->add('Access Management', [
                'class' => 'nav-title',
            ])
            ->data('order', 77);

            // Access Control Dropdown
            $accessControl = $menu->add('<i class="icon-key"></i> Access Control', [
                'class' => 'nav-item nav-dropdown',
            ])
            ->data('order', 78);
            $accessControl->link->attr([
                'class' => 'nav-link nav-dropdown-toggle',
                'href'  => '#',
            ]);

            // Submenu: Users
            $accessControl->add('<i class="icon-people"></i> Users', [
                'route' => 'backend.users.index',
                'class' => 'nav-item',
            ])
            ->data('order', 79)
            ->link->attr([
                'class' => 'nav-link',
            ]);
            // Submenu: Roles
            $accessControl->add('<i class="icon-people"></i> Roles', [
                'route' => 'backend.roles.index',
                'class' => 'nav-item',
            ])
            ->data('order', 80)
            ->link->attr([
                'class' => 'nav-link',
            ]);
        })->sortBy('order');

        return $next($request);
    }
}

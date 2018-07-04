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
            ->data([
                'order'         => 1,
                'activematches' => 'admin/dashboard*',
            ])
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
            ->data([
                'order'         => 78,
                'activematches' => [
                    'admin/roles*',
                    'admin/users*',
                ],
            ]);
            $accessControl->link->attr([
                'class' => 'nav-link nav-dropdown-toggle',
                'href'  => '#',
            ]);

            // Submenu: Users
            $accessControl->add('<i class="icon-people"></i> Users', [
                'route' => 'backend.users.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 79,
                'activematches' => 'admin/users*',
            ])
            ->link->attr([
                'class' => 'nav-link',
            ]);
            // Submenu: Roles
            $accessControl->add('<i class="icon-people"></i> Roles', [
                'route' => 'backend.roles.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order'         => 80,
                'activematches' => 'admin/roles*',
            ])
            ->link->attr([
                'class' => 'nav-link',
            ]);

            if (auth()->check() && auth()->user()->hasAnyPermission(['edit_settings'])){
                // Settings
                $menu->add('<i class="fas fa-cogs"></i> Settings', [
                    'route' => 'backend.settings',
                    'class' => 'nav-item',
                ])
                ->data([
                    'order'         => 81,
                    'activematches' => 'admin/settings*',
                ])
                ->link->attr([
                    'class' => 'nav-link',
                ]);
            }

            $menu->filter(function ($item) {
                // if ($item->title === '<i class="icon-key"></i> Access Control') {
                //     if ($item->activematches) {
                //
                //         $matches = is_array($item->activematches) ? $item->activematches : [$item->activematches];
                //
                //         foreach ($matches as $pattern) {
                //             // dd(\Request::path());
                //             // dd($pattern);
                //             if (str_is($pattern, \Request::path())) {
                //                 $item->activate();
                //                 $item->isActive = true;
                //                 dd($item);
                //             }
                //             // dd($item);
                //         }
                //     }
                // }
                if ($item->activematches) {
                    $matches = is_array($item->activematches) ? $item->activematches : [$item->activematches];

                    foreach ($matches as $pattern) {
                        if (str_is($pattern, \Request::path())) {
                            $item->activate();
                            // dd($item);
                        }
                    }
                }

                return true;
            });
        })->sortBy('order');

        return $next($request);
    }
}

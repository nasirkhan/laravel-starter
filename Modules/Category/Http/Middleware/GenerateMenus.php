<?php

namespace Modules\Category\Http\Middleware;

use Closure;

class GenerateMenus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /*
         *
         * Module Menu for Admin Backend
         *
         * *********************************************************************
         */
        \Menu::make('admin_sidebar', function ($menu) {
            // Categories
            $menu->add('<i class="nav-icon fa-solid fa-sitemap"></i> '.__('Categories'), [
                'route' => 'backend.categories.index',
                'class' => 'nav-item',
            ])
                ->data([
                    'order' => 83,
                    'activematches' => ['admin/categories*'],
                    'permission' => ['view_categories'],
                ])
                ->link->attr([
                    'class' => 'nav-link',
                ]);
        })->sortBy('order');

        return $next($request);
    }
}

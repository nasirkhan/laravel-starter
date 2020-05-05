<?php

namespace Modules\Comment\Http\Middleware;

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
        /*
         *
         * Module Menu for Admin Backend
         *
         * *********************************************************************
         */
        \Menu::make('admin_sidebar', function ($menu) {

            // comments
            $menu->add('<i class="nav-icon fas fa-comments"></i> Comments', [
                'route' => 'backend.comments.index',
                'class' => 'nav-item',
            ])
            ->data([
                'order' => 85,
                'activematches' => ['admin/comments*'],
                'permission' => ['view_comments'],
            ])
            ->link->attr([
                'class' => 'nav-link',
            ]);
        })->sortBy('order');

        return $next($request);
    }
}

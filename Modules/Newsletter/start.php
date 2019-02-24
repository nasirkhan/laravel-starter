<?php

/*
|--------------------------------------------------------------------------
| Register Namespaces and Routes
|--------------------------------------------------------------------------
|
| When your module starts, this file is executed automatically. By default
| it will only load the module's route file. However, you can expand on
| it to load anything else from the module, such as a class or view.
|
*/

if (!app()->routesAreCached()) {
    require __DIR__.'/Http/routes.php';
}

/*
 *
 * Module Menu for Admin Backend
 *
 * *************************************************************************
 */
\Menu::make('admin_sidebar', function ($menu) {
    // Newsletter Dropdown
    $newslettersControl = $menu->add('<i class="nav-icon fas fa-newspaper"></i> Newsletter', [
        'class' => 'nav-item nav-dropdown',
    ])
    ->data([
        'order'         => 66,
        'activematches' => [
            'admin/newsletters*',
        ],
        'permission'    => ['view_newsletters'],
    ]);
    $newslettersControl->link->attr([
        'class' => 'nav-link nav-dropdown-toggle',
        'href'  => '#',
    ]);

    // Submenu: Newsletter Posts
    $newslettersControl->add('<i class="nav-icon fas fa-newspaper"></i> Newsletter Posts', [
        'route' => 'backend.newsletters.index',
        'class' => 'nav-item',
    ])
    ->data('order', 67)
    ->link->attr([
        'class' => 'nav-link',
    ]);
})->sortBy('order');

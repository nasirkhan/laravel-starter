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
\Menu::makeOnce('admin_sidebar', function ($menu) {

    // Separator: Module Management
    $menu->add('Modules', [
        'class' => 'nav-title',
    ])
    ->data('order', 2);

    // Articles Dropdown
    $accessControl = $menu->add('<i class="nav-icon fas fa-file-alt"></i> Article', [
        'class' => 'nav-item nav-dropdown',
    ])
    ->data('order', 3);
    $accessControl->link->attr([
        'class' => 'nav-link nav-dropdown-toggle',
        'href'  => '#',
    ]);

    // Submenu: Posts
    $accessControl->add('<i class="nav-icon fas fa-file-alt"></i> Posts', [
        'route' => 'backend.posts.index',
        'class' => 'nav-item',
    ])
    ->data('order', 4)
    ->link->attr([
        'class' => 'nav-link',
    ]);
    // Submenu: Categories
    $accessControl->add('<i class="nav-icon fas fa-sitemap"></i> Categories', [
        'route' => 'backend.categories.index',
        'class' => 'nav-item',
    ])
    ->data('order', 5)
    ->link->attr([
        'class' => 'nav-link',
    ]);
    // Submenu: Tags
    $accessControl->add('<i class="nav-icon fas fa-tags"></i> Tags', [
        'route' => 'backend.tags.index',
        'class' => 'nav-item',
    ])
    ->data('order', 6)
    ->link->attr([
        'class' => 'nav-link',
    ]);
})->sortBy('order');

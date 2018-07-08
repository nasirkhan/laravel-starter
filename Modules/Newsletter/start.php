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
// \Menu::makeOnce('admin_sidebar', function ($menu) {
//
//     // Newsletter Dropdown
//     $accessControl = $menu->add('<i class="fas fa-newspaper"></i> Newsletter', [
//         'class' => 'nav-item nav-dropdown',
//     ])
//     ->data('order', 7);
//     $accessControl->link->attr([
//         'class' => 'nav-link nav-dropdown-toggle',
//         'href'  => '#',
//     ]);
//
//     // Submenu: Posts
//     $accessControl->add('<i class="fas fa-newspaper"></i> Newsletter Posts', [
//         'route' => 'backend.newsletters.index',
//         'class' => 'nav-item',
//     ])
//     ->data('order', 8)
//     ->link->attr([
//         'class' => 'nav-link',
//     ]);
//
// })->sortBy('order');

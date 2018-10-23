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

if (! app()->routesAreCached()) {
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
    $all_modules = $menu->add('Modules', [
        'class' => 'nav-title',
    ])
    ->data('order', 2);

    // Articles Dropdown
    $articles_menu = $menu->add('<i class="nav-icon fas fa-file-alt"></i> Article', [
        'class' => 'nav-item nav-dropdown',
    ])
    ->data([
        'order' => 3,
        'activematches' => [
            'admin/posts*',
            'admin/categories*',
            'admin/tags*',
        ],
        'permission' => ['view_posts', 'view_categories', 'view_tags'],
    ]);
    $articles_menu->link->attr([
        'class' => 'nav-link nav-dropdown-toggle',
        'href' => '#',
    ]);

    // Submenu: Posts
    $articles_menu->add('<i class="nav-icon fas fa-file-alt"></i> Posts', [
        'route' => 'backend.posts.index',
        'class' => 'nav-item',
    ])
    ->data([
        'order' => 4,
        'activematches' => 'admin/posts*',
        'permission' => ['edit_posts'],
    ])
    ->link->attr([
        'class' => 'nav-link',
    ]);
    // Submenu: Categories
    $articles_menu->add('<i class="nav-icon fas fa-sitemap"></i> Categories', [
        'route' => 'backend.categories.index',
        'class' => 'nav-item',
    ])
    ->data([
        'order' => 5,
        'activematches' => 'admin/categories*',
        'permission' => ['edit_categories'],
    ])
    ->link->attr([
        'class' => 'nav-link',
    ]);
    // Submenu: Tags
    $articles_menu->add('<i class="nav-icon fas fa-tags"></i> Tags', [
        'route' => 'backend.tags.index',
        'class' => 'nav-item',
    ])
    ->data([
        'order' => 6,
        'activematches' => 'admin/tags*',
        'permission' => ['edit_tags'],
    ])
    ->link->attr([
        'class' => 'nav-link',
    ]);
    // Submenu: Comments
    $articles_menu->add('<i class="nav-icon fas fa-comments"></i> Comments', [
        'route' => 'backend.comments.index',
        'class' => 'nav-item',
    ])
    ->data([
        'order' => 7,
        'activematches' => 'admin/comments*',
        'permission' => ['edit_comments'],
    ])
    ->link->attr([
        'class' => 'nav-link',
    ]);
})->sortBy('order');

<?php

/**
 * Backend Routes
 * Namespaces indicate folder structure
 */

Route::get('dashboard', 'BackendController@index')->name('dashboard');

Route::resource('users', 'UserController');

// Route::group(['namespace' => 'Backend'], function () {
//     // need to be logged in,
//     // user must have the permission 'view-backend'
//     // Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'permission:view-backend']], function () {
//     Route::group(['prefix' => 'admin'], function () {
//
//         // user, role and permission related routes
//         // require (__DIR__ . '/Routes/Backend/AccessRoutes.php');
//
//         // backend dashboard
//         Route::get('/', ['as' => 'backend.dashboard', 'uses' => 'BackendController@index']);
//
//         // /**
//         //  *
//         //  *  Posts Routes
//         //  *
//         //  * ---------------------------------------------------------------------
//         //  */
//         // Route::get('posts/index-data', ['as' => 'admin.posts.index-data', 'uses' => 'PostsController@index_data']);
//         // Route::get('posts/trashed', ['as' => 'admin.posts.trashed', 'uses' => 'PostsController@trashed']);
//         // Route::post('posts/trashed/{id}', ['as' => 'admin.posts.restore', 'uses' => 'PostsController@restore']);
//         // Route::resource('posts', 'PostsController');
//         //
//         // /**
//         //  *
//         //  *  Posts Routes
//         //  *
//         //  * ---------------------------------------------------------------------
//         //  */
//         // Route::get('pages/index-data', ['as' => 'admin.pages.index-data', 'uses' => 'PagesController@index_data']);
//         // Route::get('pages/trashed', ['as' => 'admin.pages.trashed', 'uses' => 'PagesController@trashed']);
//         // Route::post('pages/trashed/{id}', ['as' => 'admin.pages.restore', 'uses' => 'PagesController@restore']);
//         // Route::resource('pages', 'PagesController');
//         //
//         // /**
//         //  *
//         //  *  Categories Routes
//         //  *
//         //  * ---------------------------------------------------------------------
//         //  */
//         // Route::get('categories/index-data', ['as' => 'admin.categories.index-data', 'uses' => 'CategoriesController@index_data']);
//         // Route::get('categories/trashed', ['as' => 'admin.categories.trashed', 'uses' => 'CategoriesController@trashed']);
//         // Route::post('categories/trashed/{id}', ['as' => 'admin.categories.restore', 'uses' => 'CategoriesController@restore']);
//         // Route::resource('categories', 'CategoriesController');
//     });
// });

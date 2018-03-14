<?php

/**
 * Backend Dashboard
 * Namespaces indicate folder structure.
 */
Route::get('dashboard', 'BackendController@index')->name('dashboard');

/*
 *
 *  Users Routes
 *
 * ---------------------------------------------------------------------
 */
Route::get('users/profile', ['as' => 'users.profile', 'uses' => 'UserController@profile']);
Route::patch('users/profile', ['as' => 'users.profileUpdate', 'uses' => 'UserController@profileUpdate']);
Route::get('users/profile/edit', ['as' => 'users.profileEdit', 'uses' => 'UserController@profileEdit']);
Route::resource('users', 'UserController');

/*
 *
 *  Roles Routes
 *
 * ---------------------------------------------------------------------
 */
Route::resource('roles', 'RolesController');

/*
 *
 *  Categories Routes
 *
 * ---------------------------------------------------------------------
 */
Route::get('categories/index_data', ['as' => 'categories.index_data', 'uses' => 'CategoriesController@index_data']);
Route::get('categories/trashed', ['as' => 'categories.trashed', 'uses' => 'CategoriesController@trashed']);
Route::post('categories/trashed/{id}', ['as' => 'categories.restore', 'uses' => 'CategoriesController@restore']);
Route::resource('categories', 'CategoriesController');

/*
 *
 *  Posts Routes
 *
 * ---------------------------------------------------------------------
 */
Route::get('posts/index_data', ['as' => 'posts.index_data', 'uses' => 'PostsController@index_data']);
Route::get('posts/trashed', ['as' => 'posts.trashed', 'uses' => 'PostsController@trashed']);
Route::post('posts/trashed/{id}', ['as' => 'posts.restore', 'uses' => 'PostsController@restore']);
Route::resource('posts', 'PostsController');

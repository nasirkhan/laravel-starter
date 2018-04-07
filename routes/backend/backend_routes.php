<?php

/**
 * Backend Dashboard
 * Namespaces indicate folder structure.
 */
Route::get('/', 'BackendController@index')->name('home');
Route::get('dashboard', 'BackendController@index')->name('dashboard');

/*
 *
 *  Users Routes
 *
 * ---------------------------------------------------------------------
 */
Route::get('users/profile', ['as' => 'users.profile', 'uses' => 'UserController@profile']);
Route::get('users/profile/edit', ['as' => 'users.profileEdit', 'uses' => 'UserController@profileEdit']);
Route::patch('users/profile/edit', ['as' => 'users.profileUpdate', 'uses' => 'UserController@profileUpdate']);
Route::get('users/profile/changePassword', ['as' => 'users.changePassword', 'uses' => 'UserController@changePassword']);
Route::patch('users/profile/changePassword', ['as' => 'users.changePasswordUpdate', 'uses' => 'UserController@changePasswordUpdate']);
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
$module_name = 'categories';
$controller_name = 'CategoriesController';
Route::get("$module_name/index_list", ['as' => "$module_name.index_list", 'uses' => "$controller_name@index_list"]);
Route::get("$module_name/index_data", ['as' => "$module_name.index_data", 'uses' => "$controller_name@index_data"]);
Route::get("$module_name/trashed", ['as' => "$module_name.trashed", 'uses' => "$controller_name@trashed"]);
Route::post("$module_name/trashed/{id}", ['as' => "$module_name.restore", 'uses' => "$controller_name@restore"]);
Route::resource("$module_name", "$controller_name");

/*
 *
 *  Posts Routes
 *
 * ---------------------------------------------------------------------
 */
$module_name = 'posts';
$controller_name = 'PostsController';
Route::get("$module_name/index_data", ['as' => "$module_name.index_data", 'uses' => "$controller_name@index_data"]);
Route::get("$module_name/trashed", ['as' => "$module_name.trashed", 'uses' => "$controller_name@trashed"]);
Route::post("$module_name/trashed/{id}", ['as' => "$module_name.restore", 'uses' => "$controller_name@restore"]);
Route::resource("$module_name", "$controller_name");

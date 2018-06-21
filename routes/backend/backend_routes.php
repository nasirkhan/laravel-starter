<?php

/**
 * Backend Dashboard
 * Namespaces indicate folder structure.
 */
Route::get('/', 'BackendController@index')->name('home');
Route::get('dashboard', 'BackendController@index')->name('dashboard');


/*
 *
 *  Roles Routes
 *
 * ---------------------------------------------------------------------
 */
Route::resource('roles', 'RolesController');

/*
 *
 *  Users Routes
 *
 * ---------------------------------------------------------------------
 */
$module_name = 'users';
$controller_name = 'UserController';
Route::get("$module_name/profile", ['as' => "$module_name.profile", 'uses' => "$controller_name@profile"]);
Route::get("$module_name/profile/edit", ['as' => "$module_name.profileEdit", 'uses' => "$controller_name@profileEdit"]);
Route::patch("$module_name/profile/edit", ['as' => "$module_name.profileUpdate", 'uses' => "$controller_name@profileUpdate"]);
Route::delete("$module_name/userProviderDestroy", ['as' => "$module_name.userProviderDestroy", 'uses' => "$controller_name@userProviderDestroy"]);
Route::get("$module_name/profile/changePassword", ['as' => "$module_name.changePassword", 'uses' => "$controller_name@changePassword"]);
Route::patch("$module_name/profile/changePassword", ['as' => "$module_name.changePasswordUpdate", 'uses' => "$controller_name@changePasswordUpdate"]);
Route::get("$module_name/trashed", ['as' => "$module_name.trashed", 'uses' => "$controller_name@trashed"]);
Route::patch("$module_name/trashed/{id}", ['as' => "$module_name.restore", 'uses' => "$controller_name@restore"]);
Route::resource("$module_name", "$controller_name");
Route::patch("$module_name/{id}/block", ['as' => "$module_name.block", 'uses' => "$controller_name@block", 'middleware' => ['permission:block_users']]);
Route::patch("$module_name/{id}/unblock", ['as' => "$module_name.unblock", 'uses' => "$controller_name@unblock", 'middleware' => ['permission:block_users']]);

<?php

/**
 * Backend Dashboard
 * Namespaces indicate folder structure.
 */
Route::get('/', 'BackendController@index')->name('home');
Route::get('dashboard', 'BackendController@index')->name('dashboard');

/*
 *
 *  Settings Routes
 *
 * ---------------------------------------------------------------------
 */
Route::group(['middleware' => ['permission:edit_settings']], function () {
    Route::get('settings', 'SettingController@index')->name('settings');
    Route::post('settings', 'SettingController@store')->name('settings.store');
});

/*
 *
 *  Backup Routes
 *
 * ---------------------------------------------------------------------
 */
$module_name = 'backups';
$controller_name = 'BackupController';
Route::get("$module_name", ['as' => "$module_name.index", 'uses' => "$controller_name@index"]);
Route::get("$module_name/create", ['as' => "$module_name.create", 'uses' => "$controller_name@create"]);
Route::get("$module_name/download/{file_name}", ['as' => "$module_name.download", 'uses' => "$controller_name@download"]);
Route::get("$module_name/delete/{file_name}", ['as' => "$module_name.delete", 'uses' => "$controller_name@delete"]);

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
Route::get("$module_name/profile/{id}", ['as' => "$module_name.profile", 'uses' => "$controller_name@profile"]);
Route::get("$module_name/profile/{id}/edit", ['as' => "$module_name.profileEdit", 'uses' => "$controller_name@profileEdit"]);
Route::patch("$module_name/profile/{id}/edit", ['as' => "$module_name.profileUpdate", 'uses' => "$controller_name@profileUpdate"]);
Route::get("$module_name/emailConfirmation/{confirmation_code}", ['as' => "$module_name.emailConfirmation", 'uses' => "$controller_name@emailConfirmation"]);
Route::get("$module_name/emailConfirmationResend/{hashid}", ['as' => "$module_name.emailConfirmationResend", 'uses' => "$controller_name@emailConfirmationResend"]);
Route::delete("$module_name/userProviderDestroy", ['as' => "$module_name.userProviderDestroy", 'uses' => "$controller_name@userProviderDestroy"]);
Route::get("$module_name/profile/changeProfilePassword/{id}", ['as' => "$module_name.changeProfilePassword", 'uses' => "$controller_name@changeProfilePassword"]);
Route::patch("$module_name/profile/changeProfilePassword/{id}", ['as' => "$module_name.changeProfilePasswordUpdate", 'uses' => "$controller_name@changeProfilePasswordUpdate"]);
Route::get("$module_name/changePassword/{id}", ['as' => "$module_name.changePassword", 'uses' => "$controller_name@changePassword"]);
Route::patch("$module_name/changePassword/{id}", ['as' => "$module_name.changePasswordUpdate", 'uses' => "$controller_name@changePasswordUpdate"]);
Route::get("$module_name/trashed", ['as' => "$module_name.trashed", 'uses' => "$controller_name@trashed"]);
Route::patch("$module_name/trashed/{id}", ['as' => "$module_name.restore", 'uses' => "$controller_name@restore"]);
Route::get("$module_name/index_data", ['as' => "$module_name.index_data", 'uses' => "$controller_name@index_data"]);
Route::resource("$module_name", "$controller_name");
Route::patch("$module_name/{id}/block", ['as' => "$module_name.block", 'uses' => "$controller_name@block", 'middleware' => ['permission:block_users']]);
Route::patch("$module_name/{id}/unblock", ['as' => "$module_name.unblock", 'uses' => "$controller_name@unblock", 'middleware' => ['permission:block_users']]);

<?php
/*
*
* Frontend Routes
*
* --------------------------------------------------------------------
*/

Route::get('/', 'FrontendController@index')->name('index');
Route::get('home', 'FrontendController@index')->name('home');

Route::group(['middleware' => ['auth']], function () {
    // Route::get('profile', 'FrontendController@profile')->name('profile');
    Route::get('users/{id}', ['as' => 'users.show', 'uses' => 'UserController@show']);

    Route::get('profile', ['as' => 'users.profile', 'uses' => 'UserController@profile']);
    Route::get('profile/edit', ['as' => 'users.profileEdit', 'uses' => 'UserController@profileEdit']);
    Route::patch('profile/edit', ['as' => 'users.profileUpdate', 'uses' => 'UserController@profileUpdate']);
    Route::delete('users/userProviderDestroy', ['as' => 'users.userProviderDestroy', 'uses' => 'UserController@userProviderDestroy']);
    Route::get('users/profile/changePassword', ['as' => 'users.changePassword', 'uses' => 'UserController@changePassword']);
    Route::patch('users/profile/changePassword', ['as' => 'users.changePasswordUpdate', 'uses' => 'UserController@changePasswordUpdate']);
});

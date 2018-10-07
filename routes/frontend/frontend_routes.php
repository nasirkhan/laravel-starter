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
    Route::get('users/emailConfirmation/{confirmation_code}', ['as' => 'users.emailConfirmation', 'uses' => 'UserController@emailConfirmation']);
    Route::get('users/emailConfirmationResend/{hashid}', ['as' => 'users.emailConfirmationResend', 'uses' => 'UserController@emailConfirmationResend']);

    Route::get('profile/{id}', ['as' => 'users.profile', 'uses' => 'UserController@profile']);
    Route::get('profile/{id}/edit', ['as' => 'users.profileEdit', 'uses' => 'UserController@profileEdit']);
    Route::patch('profile/{id}/edit', ['as' => 'users.profileUpdate', 'uses' => 'UserController@profileUpdate']);
    Route::delete('users/userProviderDestroy', ['as' => 'users.userProviderDestroy', 'uses' => 'UserController@userProviderDestroy']);
    Route::get('users/profile/changePassword/{id}', ['as' => 'users.changePassword', 'uses' => 'UserController@changePassword']);
    Route::patch('users/profile/changePassword/{id}', ['as' => 'users.changePasswordUpdate', 'uses' => 'UserController@changePasswordUpdate']);
});

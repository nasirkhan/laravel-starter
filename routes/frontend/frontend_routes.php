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
    Route::get('profile', 'FrontendController@profile')->name('profile');
});
